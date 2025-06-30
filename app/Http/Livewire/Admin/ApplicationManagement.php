<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\ExamResult;
use App\Models\Application;
use App\Models\ApplicantProfile;

class ApplicationManagement extends Component
{
    public $showProfileModal = false;
    public $selectedProfile = null;
    public $showDocumentModal = false;
    public $selectedDocuments = null;
    public $showExamModal = false;
    public $examResults = [];
    protected $applications;

    // Method untuk buka modal profil
    public function viewProfile($applicantProfileId)
    {
        $this->selectedProfile = ApplicantProfile::with([
            'education.majorities.grade',
            'user'
        ])->find($applicantProfileId);

        if (!$this->selectedProfile) {
            session()->flash('error', 'Profil tidak ditemukan');
            return;
        }

        $this->showProfileModal = true;
    }

    public function closeModal()
    {
        $this->showProfileModal = false;
        $this->selectedProfile = null;
    }

    public function viewDocuments($applicantProfileId)
    {
        $profile = ApplicantProfile::with('application')->find($applicantProfileId);

        if (!$profile || !$profile->application) {
            session()->flash('error', 'Dokumen tidak ditemukan.');
            return;
        }

        $this->selectedDocuments = [
            'cv' => $profile->application->cv_path,
            'transkrip' => $profile->application->transkrip_path,
            'pakelaring' => $profile->application->pakelaring_path,
            'sertifikat' => $profile->application->sertifikat_path,
        ];

        $this->showDocumentModal = true;
    }

    public function viewExam($applicantProfileId)
    {
        // Ambil semua exam_result dengan relasi application → job
        $this->examResults = ExamResult::with(['application.job'])
            ->whereHas('application', function ($query) use ($applicantProfileId) {
                $query->where('applicant_profile_id', $applicantProfileId);
            })
            ->get()
            ->map(function ($result) {
                return [
                    'exam_title' => optional($result->examTitle)->title ?? '-',
                    'exam_type' => optional($result->examTitle)->exam_type ?? '-',
                    'score' => $result->score,
                    'started_at' => \Carbon\Carbon::parse($result->started_at)->format('d F Y H:i'),
                    'finished_at' => \Carbon\Carbon::parse($result->finished_at)->format('d F Y H:i'),
                ];
            })->toArray();

        if (empty($this->examResults)) {
            session()->flash('error', 'Belum ada hasil ujian ditemukan.');
            return;
        }

        $this->showExamModal = true;
    }

    public function closeDocumentModal()
    {
        $this->showDocumentModal = false;
        $this->selectedDocuments = [];
    }

    public function closeExamModal()
    {
        $this->showExamModal = false;
        $this->examResults = [];
    }
    public function render()
    {
        $applications = Application::with([
            'applicantProfile.user',
            'job'
        ])->paginate(10);

        return view('livewire.admin.application-management', [
            'applications' => $applications
        ]);
    }
}
