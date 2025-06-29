<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Application;
use App\Models\ApplicantProfile;

class ApplicationManagement extends Component
{
    public $showProfileModal = false;
    public $selectedProfile = null;

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