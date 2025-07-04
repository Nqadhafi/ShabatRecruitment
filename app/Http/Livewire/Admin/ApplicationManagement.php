<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\ExamResult;
use App\Models\Application;
use App\Models\ApplicantProfile;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterviewCallMail;
use App\Mail\RejectionMail;
use App\Mail\HiredMail;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ApplicationManagement extends Component
{
    use WithFileUploads;
    public $showProfileModal = false;
    public $selectedProfile = null;
    public $showDocumentModal = false;
    public $selectedDocuments = null;
    public $showExamModal = false;
    public $examResults = [];
    public $offeringLetterPdf;

    public $showProcessModal = false;
    public $selectedApplicationId = null;
    public $selectedStatus = '';
    public $interviewMessage = '';
    public $rejectionReason = '';
    public $offeringLetter = '';
    public $applicantName = '';
    public $applicantEmail = '';
    public $applicantPhone = '';
    public $jobName = '';

    protected $applications;

public function processApplication($applicationId)
{
    $application = Application::with(['applicantProfile.user', 'job'])->find($applicationId);

    if (!$application) {
        session()->flash('error', 'Lamaran tidak ditemukan.');
        return;
    }

    $this->selectedApplicationId = $application->id;
    $this->selectedStatus = $application->status;
    $this->applicantName = $application->applicantProfile->full_name ?? '-';
    $this->applicantEmail = optional($application->applicantProfile->user)->email ?? '-';
    $this->applicantPhone = $application->applicantProfile->phone_number ?? '-';
    $this->jobName = optional($application->job)->name ?? '-';

    $this->interviewMessage = $application->interview_message ?? '';
    $this->rejectionReason = $application->rejection_reason ?? '';
    $this->offeringLetter = $application->offering_letter ?? '';
    $this->offeringLetterPdf = null; // Reset file upload
    $this->showProcessModal = true;
}

public function updateApplicationStatus()
{
    $application = Application::find($this->selectedApplicationId);
    if (!$application) {
        session()->flash('error', 'Lamaran tidak ditemukan.');
        return;
    }

    // Update status lamaran
    $data = ['status' => $this->selectedStatus];

    if ($this->selectedStatus === 'processed') {
        $data['interview_message'] = $this->interviewMessage;
    } elseif ($this->selectedStatus === 'rejected') {
        $data['rejection_reason'] = $this->rejectionReason;
    } elseif ($this->selectedStatus === 'hired') {
        $data['offering_letter'] = $this->offeringLetter;

        // Validasi apakah file PDF sudah diupload
        if ($this->offeringLetterPdf) {
            // Simpan file ke storage/app/public/offering_letters/
            
            $filename = 'offering_letter_' . $application->applicantProfile->full_name . '.' . $this->offeringLetterPdf->getClientOriginalExtension();
            $filePath = $this->offeringLetterPdf->storeAs('offering_letters', $filename, 'public');

            // Update path di database
            $application->update(['offering_letter_path' => $filePath]);

            // Lampirkan file ke email
            $mail = new HiredMail($application, $this->offeringLetter, $filePath);
        } else {
            $mail = new HiredMail($application, $this->offeringLetter, null);
        }

        Mail::to($application->applicantProfile->user->email)->send($mail);
    }

    $application->update($data);

    // Format nomor HP untuk WhatsApp
    $nomorWhatsapp = $application->applicantProfile->phone_number ?? '';
    if (substr($nomorWhatsapp, 0, 1) === '0') {
        $nomorWhatsapp = '62' . substr($nomorWhatsapp, 1); // Ganti format ke internasional
    }

    // Buat pesan WhatsApp sesuai status
    if ($this->selectedStatus === 'processed') {
        $pesan = "Halo, Anda dipanggil wawancara untuk lowongan {$this->jobName}. Detail: {$this->interviewMessage}";
    } elseif ($this->selectedStatus === 'rejected') {
        $pesan = "Mohon maaf, lamaran Anda belum dapat dilanjutkan.";
    } elseif ($this->selectedStatus === 'hired') {
        $pesan = "Selamat! Lamaran Anda diterima.\n\nSilakan cek email Anda untuk detail offering letter.";
    }

    $whatsappUrl = "https://wa.me/ {$nomorWhatsapp}?text=" . urlencode($pesan);

    // Tutup modal proses
    $this->showProcessModal = false;
    session()->flash('success', 'Status lamaran berhasil diperbarui & notifikasi telah dikirim.');

    // Buka WhatsApp secara otomatis
    $this->dispatchBrowserEvent('open-whatsapp', ['url' => $whatsappUrl]);
}

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


    public function viewDocuments($applicationId)
{
    // Ambil application beserta applicant & job
    $application = Application::with(['applicantProfile', 'job'])->find($applicationId);

    if (!$application) {
        session()->flash('error', 'Lamaran tidak ditemukan.');
        return;
    }

    // Cek apakah ada dokumen
    $this->selectedDocuments = [
        'cv' => $application->cv_path,
        'transkrip' => $application->transkrip_path,
        'pakelaring' => $application->pakelaring_path,
        'sertifikat' => $application->sertifikat_path,
    ];

    $this->showDocumentModal = true;
}

public function viewExam($applicationId)
{
    // Ambil application beserta applicant & job
    $application = Application::with(['applicantProfile.user', 'job'])->find($applicationId);

    if (!$application) {
        session()->flash('error', 'Lamaran tidak ditemukan.');
        return;
    }

    // Ambil semua exam_result berdasarkan application_id
    $this->examResults = ExamResult::with('examTitle')
        ->where('application_id', $applicationId)
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
        session()->flash('error', 'Belum ada hasil ujian untuk lamaran ini.');
        return;
    }

    // Simpan data tambahan untuk ditampilkan di modal
    $this->applicantName = $application->applicantProfile->full_name ?? '-';
    $this->jobName = $application->job->name ?? '-';
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
    public function closeModal()
    {
        $this->showProfileModal = false;
        $this->selectedProfile = null;
    }

    public function closeProcessModal()
    {
        $this->showProcessModal = false;
        $this->selectedApplicationId = null;
        $this->selectedStatus = '';
        $this->interviewMessage = '';
        $this->rejectionReason = '';
        $this->offeringLetter = '';
        $this->applicantName = '';
        $this->applicantEmail = '';
        $this->applicantPhone = '';
        $this->jobName = '';
    }

public function render()
{
    $applications = Application::with([
        'applicantProfile.user',
        'job'
    ])->get(); // ambil semua data

    // Kelompokkan berdasarkan status
    $groupedApplications = $applications->groupBy('status');

    return view('livewire.admin.application-management', [
        'groupedApplications' => $groupedApplications
    ]);
}
}
