<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Application;
use App\Models\ApplicantProfile;

class ApplicationManagement extends Component
{
    public $showProfileModal = false;
    public $selectedProfile = null;
    public $showDocumentModal = false;
    public $selectedDocuments = null;
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

    public function closeDocumentModal()
    {
        $this->showDocumentModal = false;
        $this->selectedDocuments = [];
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
