<?php
namespace App\Http\Livewire;

use App\Models\Grade;
use Livewire\Component;
use App\Models\Job;

class Home extends Component
{
    public $jobs;  // Store jobs data as an array or collection
    public $grades;
    public $selectedGrade = null; // For storing the selected grade
    public $page = 1;
    public $noJobsMessage = null; // For displaying "no jobs" message

    // Prepare initial data
    public function mount()
    {
        $this->grades = Grade::withCount('jobs')->get(); // Count the number of jobs per grade
        $this->jobs = Job::with('grade')->get(); // Get all jobs initially
        if ($this->jobs->isEmpty()) {
            $this->noJobsMessage = "Tidak ada lowongan pekerjaan untuk kategori ini."; // Set the no jobs message
        } else {
            $this->noJobsMessage = null; // Clear message if jobs exist
        }
    }

    // Update jobs when selected grade changes
    public function updatedSelectedGrade()
    {
        $this->page = 1; // Reset page when grade changes

        // Filter jobs by selected grade
        $this->jobs = Job::with('grade')
                         ->where('min_grades', $this->selectedGrade)
                         ->get(); // Use grade_id for filtering

        // Check if no jobs are found for the selected grade
        if ($this->jobs->isEmpty()) {
            $this->noJobsMessage = "Tidak ada lowongan pekerjaan untuk kategori ini."; // Set the no jobs message
        } else {
            $this->noJobsMessage = null; // Clear message if jobs exist
        }
    }

    // Show all jobs (reset grade filter)
    public function showAllJobs()
    {
        $this->page = 1;
        $this->jobs = Job::with('grade')->get(); // Get all jobs
                if ($this->jobs->isEmpty()) {
            $this->noJobsMessage = "Tidak ada lowongan pekerjaan untuk kategori ini."; // Set the no jobs message
        } else {
            $this->noJobsMessage = null; // Clear message if jobs exist
        }
    }

    public function render()
    {
        return view('livewire.home'); // Render the home view
    }
}
