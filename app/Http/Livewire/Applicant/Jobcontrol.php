<?php

namespace App\Http\Livewire\Applicant;

use App\Models\Application;
use App\Models\ExamResult;
use App\Models\Job;
use Livewire\Component;

class Jobcontrol extends Component
{
    public $jobs, $selectedJob;
    public $selectedGradeFilter = '';
    public $gradeOptions = [];
    public $showConfirmModal = false;
    public $confirmMessage = '';
    public $canApply = true;
    public $applications = [];
    public $hasTakenExam = false;

    public function mount()
    {
        $this->jobs = Job::with('grade')->where('is_active', '1')->get();
        $this->selectedJob = null;

            $applicantId = auth()->user()->applicantProfile->id ?? null;
    
    if ($applicantId) {
        // Ambil semua job_id yang sudah dilamar
        $this->applications = Application::where('applicant_profile_id', $applicantId)
            ->pluck('job_id')
            ->toArray();
    }
    }

    public function selectJob($jobId)
    {

        $this->selectedJob = Job::find($jobId);
    }

    public function applyNow()
    {
        // Ambil profil pelamar
        $applicant = auth()->user()->applicantProfile;

        if (!$applicant) {
            return redirect()->route('profile.complete');
        }

        // Ambil grade pelamar via education → majority → grade
        $applicantGradeName = optional(optional(optional($applicant->education)->majorities)->grade)->name;

        // Ambil grade minimal dari job
        $requiredGradeName = optional($this->selectedJob->grade)->name;

        if (!$applicantGradeName || !$requiredGradeName) {
            $this->canApply = false;
            $this->confirmMessage = 'Data pendidikan atau grade lowongan tidak ditemukan.';
        }
        switch ($requiredGradeName) {
            case 'Sarjana':
                $this->canApply = $applicantGradeName === 'Sarjana';
                break;
            case 'Diploma':
                $this->canApply = in_array($applicantGradeName, ['Sarjana', 'Diploma']);
                break;
            case 'SMA/SMK':
                $this->canApply = in_array($applicantGradeName, ['Sarjana', 'Diploma', 'SMA/SMK']);
                break;
            default:
                $this->canApply = false;
        }
        if ($this->canApply) {
            $this->confirmMessage = 'Apakah Anda yakin ingin melamar pekerjaan ini?';
        } else {
            $this->confirmMessage = 'Tingkat pendidikan Anda tidak sesuai dengan persyaratan lowongan ini.';
        }


        $this->showConfirmModal = true;
    }

    public function confirmApply()
    {
        $this->showConfirmModal = false;

        if ($this->canApply) {
            // Nanti disini kita tambahkan logika upload dokumen
            session()->flash('success', 'Anda memenuhi kriteria grade. Lanjutkan mengunggah dokumen.');
            return redirect()->route('applicant.apply.form', $this->selectedJob->id);
            // Contoh: redirect ke form lamaran
            // return redirect()->route('applicant.apply.form', $this->selectedJob->id);
        }
    }

    public function render()
    {

        return view('livewire.applicant.jobcontrol');
    }
}
