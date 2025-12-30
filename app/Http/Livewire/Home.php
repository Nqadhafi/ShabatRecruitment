<?php

namespace App\Http\Livewire;

use App\Models\Grade;
use Livewire\Component;
use App\Models\Job;

class Home extends Component
{
    public $allJobs;      // Menyimpan semua job dari awal
    public $jobs;         // Untuk menampilkan hasil filter
    public $grades;
    public $selectedGrade = null;
    public $noJobsMessage = null;

    public function mount()
    {
        // Ambil semua grade dengan hitungan job
        $this->grades = Grade::withCount([
            'jobs' => function ($query) {
                $query->where('is_active', 1);
            }
        ])->get();

        // Ambil SEMUA job SEKALI dan simpan di $allJobs
        $this->allJobs = Job::with('grade')->where('is_active', 1)->get();

        // Inisialisasi jobs sebagai semua job
        $this->jobs = $this->allJobs;

        // Set pesan jika tidak ada job
        $this->noJobsMessage = $this->jobs->isEmpty()
            ? "Tidak ada lowongan pekerjaan untuk kategori ini."
            : null;
    }

    public function updatedSelectedGrade()
    {
        // Filter job dari data lokal (tanpa query ulang)
        if ($this->selectedGrade) {
            $this->jobs = $this->allJobs->filter(function ($job) {
                return $job->min_grades == $this->selectedGrade;
            });
        } else {
            $this->jobs = $this->allJobs;
        }

        // Update pesan jika tidak ada job hasil filter
        $this->noJobsMessage = $this->jobs->isEmpty()
            ? "Tidak ada lowongan pekerjaan untuk kategori ini."
            : null;
    }

    public function showAllJobs()
    {
        $this->selectedGrade = null;
        $this->jobs = $this->allJobs;

        $this->noJobsMessage = $this->jobs->isEmpty()
            ? "Tidak ada lowongan pekerjaan untuk kategori ini."
            : null;
    }

    public function render()
    {
        return view('livewire.home');
    }
}
