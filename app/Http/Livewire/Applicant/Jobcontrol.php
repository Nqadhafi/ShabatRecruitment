<?php

namespace App\Http\Livewire\Applicant;

use App\Models\Job;
use Livewire\Component;

class Jobcontrol extends Component
{
    public $jobs, $selectedJob;

    public function mount(){
        $this->jobs = Job::with('grade')->where('is_active', '1')->get();
        $this->selectedJob = null;
    }

    public function selectJob($jobId){

        $this->selectedJob = Job::find($jobId);
    }

    public function render()
    {

        return view('livewire.applicant.jobcontrol');
    }
}
