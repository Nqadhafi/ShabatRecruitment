<?php

namespace App\Http\Livewire\Applicant;

use App\Models\Application;
use App\Models\Job;
use Livewire\Component;
use Livewire\WithFileUploads;

class ApplicationForm extends Component
{
    use WithFileUploads;

    public $jobId;
    public $cv, $pakelaring, $transkrip, $sertifikat;
    public $cvPath, $pakelaringPath, $transkripPath, $sertifikatPath;

    protected $rules = [
        'cv' => 'required|file|mimes:pdf|max:2048',
        'transkrip' => 'required|file|mimes:pdf|max:2048',
        'pakelaring' => 'nullable|file|mimes:pdf|max:2048',
        'sertifikat' => 'nullable|file|mimes:pdf|max:2048',
    ];

    public function mount($jobId)
    {
        $this->jobId = $jobId;
    }

    public function submit()
    {
        $this->validate();

        // Simpan file
        $cvPath = $this->cv->store('applications/cv', 'public');
        $transkripPath = $this->transkrip->store('applications/transkrip', 'public');
        $pakelaringPath = $this->pakelaring ? $this->pakelaring->store('applications/pakelaring', 'public') : null;
        $sertifikatPath = $this->sertifikat ? $this->sertifikat->store('applications/sertifikat', 'public') : null;

        $application = Application::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'job_id' => $this->jobId,
            'applicant_profile_id' => auth()->user()->applicantProfile->id,
            'cv_path' => $cvPath,
            'pakelaring_path' => $pakelaringPath ?? '-',
            'transkrip_path' => $transkripPath,
            'sertifikat_path' => $sertifikatPath ?? '-',
            'status' => 'applied'
        ]);

  session()->put('application_id', $application->id);
        return redirect()->route('applicant.exam.start');
    }

    public function render()
    {
        $job = Job::find($this->jobId);
        return view('livewire.applicant.application-form', compact('job'));
    }
}