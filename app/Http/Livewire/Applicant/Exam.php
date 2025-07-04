<?php

namespace App\Http\Livewire\Applicant;
use Livewire\Component;
use App\Models\ExamTitle;
use App\Models\ExamResult;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
                }
            } else {
                $points = json_decode($question['points'], true);
                $totalScore += $points[$userAnswer] ?? 0;
            }
        }
        $applicationId = session('application_id');
        // Simpan hasil ujian
        ExamResult::create([
            'exam_title_id' => $this->examTitle->id,
            'user_id' => Auth::id(),
            'application_id' => $applicationId,       
            'score' => $totalScore,
            'started_at' => $this->startTime,
            'finished_at' => now(),
        ]);

        // Cek apakah masih ada ujian berikutnya
        if ($this->currentTitleIndex + 1 < $this->titles->count()) {
            $this->currentTitleIndex++;
            $this->currentQuestionIndex = 0;
            $this->answers = []; // Reset jawaban
            $this->loadCurrentExam(); // Muat ujian baru
        } else {

            foreach ($this->titles as $title) {
            session()->forget(["exam_{$title->id}_start_time", "exam_{$title->id}_time_left"]);
        }
            session()->forget('application_id');
            return redirect()->route('applicant.exam.thanks');
        }
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
