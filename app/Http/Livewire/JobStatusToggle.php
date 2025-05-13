<?php

namespace App\Http\Livewire;

use App\Models\Job;
use Livewire\Component;

class JobStatusToggle extends Component
{
    public $job; // Variabel untuk menyimpan job

    public function mount(Job $job)
    {
        // Set job dari parameter yang diterima
        $this->job = $job;
    }

    public function toggleStatus()
    {
        // Toggle status is_active
        $this->job->is_active = !$this->job->is_active;
        $this->job->save();

        // Emit event untuk memberi tahu bahwa status sudah diperbarui
        // session()->flash('success', 'Job status updated successfully.');
        $this->emit('jobStatusUpdated', $this->job->id, $this->job->is_active); 
    }

    public function render()
    {
        return view('livewire.admin.job-status-toggle');
    }
}
