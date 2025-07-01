<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ApplicantProfileController extends Controller
{
    //
    public function edit()
    {
        $applicantProfile = Auth::user()->applicantProfile;

        if (!$applicantProfile) {
            return redirect()->route('applicant.dashboard')->with('error', 'Profil tidak ditemukan.');
        }

        return view('applicant.profile', compact('applicantProfile'));
    }

public function update(Request $request)
{
    $applicantProfile = Auth::user()->applicantProfile;

    if (!$applicantProfile) {
        return redirect()->route('applicant.dashboard')->with('error', 'Profil tidak ditemukan.');
    }

    // Validasi form
    $request->validate([
        'full_name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'ktp_number' => 'required|string|max:16',
        'address' => 'required|string',
        'phone_number' => 'required|string|regex:/^([0][8][1-9][0-9]{7,11})$/',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
    ]);

    // Cek apakah KTP diubah
    if ($request->ktp_number !== $applicantProfile->ktp_number) {
        return redirect()->back()->with('error', 'Nomor KTP tidak bisa diubah.');
    }

    // Proses upload foto jika ada
    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada
if ($applicantProfile->photo_path) {
    // Hanya coba hapus jika file benar-benar ada
    if (Storage::disk('public')->exists($applicantProfile->photo_path)) {
        Storage::disk('public')->delete($applicantProfile->photo_path);
    }
}

        // Simpan foto baru dengan UUID
        $file = $request->file('photo');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('photos', $filename, 'public');

        // Update path foto di database
        $applicantProfile->update(['photo_path' => $path]);
    }

    // Update data profil
    $applicantProfile->update($request->only([
        'full_name', 'surname', 'ktp_number', 'address', 'phone_number'
    ]));

    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
}
}
