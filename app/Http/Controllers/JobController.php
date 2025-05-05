<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // Menampilkan daftar lowongan pekerjaan
    public function index()
    {
        $jobs = Job::all();
        return view('admin.jobs.index', compact('jobs'));
    }

    // Menampilkan form untuk membuat lowongan baru
    public function create()
    {
        return view('admin.jobs.create');
    }

    // Menyimpan lowongan pekerjaan yang baru
    public function store(Request $request)
    {
        // Debugging: Periksa apakah data dikirim dengan benar
        // dd($request->all());
    
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'requirement' => 'required|string',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Proses penyimpanan job
        $job = new Job;
        $job->name = $request->name;
        $job->description = $request->description;
        $job->requirement = $request->requirement;
        $job->is_active = true;
    
        if ($request->hasFile('photo_path')) {
            $job->photo_path = $request->file('photo_path')->store('public/jobs');
        }
    
        $job->save();
    
        return redirect()->route('admin.jobs.index')->with('success', 'Job created successfully');
    }
    
    
    
    

    // Menampilkan form untuk mengedit lowongan
    public function edit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    // Mengupdate data lowongan pekerjaan
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'requirement' => 'required|string',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi foto/logo
        ]);

        $job->name = $request->name;
        $job->description = $request->description;
        $job->requirement = $request->requirement;
        if ($request->hasFile('photo_path')) {
            $job->photo_path = $request->file('photo_path')->store('public/jobs');
        }
        $job->save();

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully');
    }
    // JobController.php

    public function toggle(Job $job)
    {
        $job->is_active = !$job->is_active;
        $job->save();

        return redirect()->route('admin.jobs.index')->with('success', 'Job status updated successfully');
    }

    // Menghapus lowongan pekerjaan
    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully');
    }
}
