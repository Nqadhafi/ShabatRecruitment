<?php

namespace App\Http\Livewire\Applicant;
use Livewire\Component;
use App\Models\ExamTitle;
use App\Models\ExamResult;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Exam extends Component
{
    public $titles = [];
    public $currentTitleIndex = 0;
    public $questions = [];
    public $currentQuestionIndex = 0;
    public $answers = [];
    public $timeLeft = 0;
    public $startTime;
    public $examTitle;
    

    public function mount()
    {
        // Ambil semua judul ujian yang aktif
        $this->titles = ExamTitle::where('is_active', true)
            ->with('questions')
            ->orderBy('id')
            ->get()
            // ->filter(fn($title) => !$this->hasTaken($title))
            ->values();

        if ($this->titles->isEmpty()) {
            return redirect()->route('applicant.exam.thanks');
        }

        // Muat soal pertama
        $this->loadCurrentExam();
    }

    protected function loadCurrentExam()
    {
        $title = $this->titles[$this->currentTitleIndex];

        // Simpan judul aktif saat ini
        $this->examTitle = $title;

        // Ambil soal dalam judul ini
        $this->questions = $title->questions->toArray();

        // Acak urutan jika diperlukan
        if ($title->is_random) {
            shuffle($this->questions);
        }

$duration = $title->duration_minutes ? $title->duration_minutes * 60 : null;

    if (!$duration) {
        $this->timeLeft = 0;
        return;
    }

    $sessionStartTimeKey = "exam_{$title->id}_start_time";
    $sessionTimeLeftKey = "exam_{$title->id}_time_left";

    if (session()->has($sessionStartTimeKey) && session()->has($sessionTimeLeftKey)) {
        $this->startTime = session()->get($sessionStartTimeKey);
        $elapsed = now()->diffInSeconds(\Carbon\Carbon::parse($this->startTime));
        $remaining = max(0, session()->get($sessionTimeLeftKey) - $elapsed);

        $this->timeLeft = $remaining;
    } else {
        // Jika belum ada sesi, mulai timer baru
        $this->startTime = now();
        $this->timeLeft = $duration;

        session()->put($sessionStartTimeKey, $this->startTime);
        session()->put($sessionTimeLeftKey, $this->timeLeft);
    }
    }

    public function updatedTimeLeft()
    {
    $titleId = $this->examTitle->id;
    $key = "exam_{$titleId}_time_left";
    
    session()->put($key, $this->timeLeft);
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function prevQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function goToQuestion($index)
    {
        $this->currentQuestionIndex = $index;
    }

public function submit()
{
    $totalScore = 0;

    foreach ($this->questions as $index => $question) {
        $userAnswer = $this->answers[$index] ?? null;
        if (!$userAnswer) continue;

        if ($this->examTitle->exam_type === 'benar_salah') {
            if ($userAnswer === $question['correct_answer']) {
                $totalScore += 1;
            } else {
                // kamu bilang salah sudah diberi poin 3 di logika kamu;
                // jika itu berada di tempat lain, biarkan bagian ini apa adanya.
            }
        } else {
            $points = json_decode($question['points'], true);
            $totalScore += $points[$userAnswer] ?? 0;
        }
    }

    // === Khusus Psikotes: randomize nilai akhir (tanpa mengubah per-soal) ===
    if ($this->isPsikotes()) {
        $totalScore = $this->randomizeScore((int) $totalScore, 0.20); // ±20%
        // kalau mau range tetap (mis. 85–130), tinggal ganti:
        // $totalScore = mt_rand(85, 130);
    }
    // =======================================================================

    $applicationId = session('application_id');

    ExamResult::create([
        'exam_title_id' => $this->examTitle->id,
        'user_id'       => Auth::id(),
        'application_id'=> $applicationId,
        'score'         => (int) $totalScore,
        'started_at'    => $this->startTime,
        'finished_at'   => now(),
    ]);

    if ($this->currentTitleIndex + 1 < $this->titles->count()) {
        $this->currentTitleIndex++;
        $this->currentQuestionIndex = 0;
        $this->answers = [];
        $this->loadCurrentExam();
    } else {
        foreach ($this->titles as $title) {
            session()->forget(["exam_{$title->id}_start_time", "exam_{$title->id}_time_left"]);
        }
        session()->forget('application_id');
        return redirect()->route('applicant.application.history')->with('success', 'Ujian selesai! Hasil telah disimpan.');
    }
}


    private function isPsikotes(): bool
{
    $name = Str::lower($this->examTitle->title ?? $this->examTitle->name ?? '');
    return $name === 'psikotes';
}

private function randomizeScore(int $score, float $pct = 0.20): int
{
    // Range relatif: ±20% (bisa ubah via argumen $pct)
    $min = max(0, (int) round($score * (1 - $pct)));
    $max = (int) round($score * (1 + $pct));

    if ($max < $min) {
        [$min, $max] = [$max, $min];
    }
    if ($max === $min) {
        $max = $min + 1; // jaga-jaga kalau skornya 0 atau range mengerucut
    }

    return mt_rand($min, $max);
}


    public function render()
    {
        
        $current = $this->questions[$this->currentQuestionIndex] ?? [];
        return view('livewire.applicant.exam', [
            'current' => $current,
            'examTitle' => $this->examTitle,
        ]);
    }
}
