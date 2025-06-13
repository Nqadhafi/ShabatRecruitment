<?php

namespace App\Http\Livewire\Applicant;
use App\Models\ExamTitle;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Exam extends Component
{
    public $examTitle;
    public $questions = [];
    public $currentQuestionIndex = 0;
    public $answers = [];

    public $timeLeft = 0;
    public $startTime;

    protected $queryString = ['examTitle'];

    public function mount(ExamTitle $examTitle)
    {
        dd($examTitle);        // Cek apakah ujian aktif
        if (!$examTitle->is_active) {
            abort(403, 'Ujian tidak tersedia');
        }
        // Cek apakah user sudah pernah ikut ujian ini
        $existing = ExamResult::where('exam_title_id', $examTitle->id)
            ->where('user_id', Auth::id())
            ->first();
        if ($existing) {
            return redirect()->route('applicant.exam.thanks');
        }
        // Simpan data judul ujian
        $this->examTitle = $examTitle;
        // Ambil soal
        $this->questions = $examTitle->questions->toArray();
        // Acak jika diperlukan
        if ($examTitle->is_random) {
            shuffle($this->questions);
        }
        // Timer
        if ($examTitle->duration_minutes) {
            $this->timeLeft = $examTitle->duration_minutes * 60;
        }
        // Waktu mulai
        $this->startTime = now();
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

        // Simpan hasil ujian
        ExamResult::create([
            'exam_title_id' => $this->examTitle->id,
            'user_id' => Auth::user()->id,
            'score' => $totalScore,
            'started_at' => $this->startTime,
            'finished_at' => now(),
        ]);

        // Redirect ke halaman terima kasih
        return redirect()->route('applicant.exam.thanks');
    }

    public function render()
    {
        return view('livewire.applicant.exam');
    }
}
