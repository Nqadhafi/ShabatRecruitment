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

class ApplicationManagement extends Component
{
    public $showProfileModal = false;
    public $selectedProfile = null;
    public $showDocumentModal = false;
    public $selectedDocuments = null;
    public $showExamModal = false;
    public $examResults = [];

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

    $this->showProcessModal = true;
}

public function updateApplicationStatus()
{
    $application = Application::find($this->selectedApplicationId);
    if (!$application) {
        session()->flash('error', 'Lamaran tidak ditemukan.');
        return;
    }

    $data = ['status' => $this->selectedStatus];

    if ($this->selectedStatus === 'processed') {
        $data['interview_message'] = $this->interviewMessage;
    } elseif ($this->selectedStatus === 'rejected') {
        $data['rejection_reason'] = $this->rejectionReason;
    } elseif ($this->selectedStatus === 'hired') {
        $data['offering_letter'] = $this->offeringLetter;
    }

    $application->update($data);

    // Kirim email sesuai status
    if ($this->selectedStatus === 'processed') {
        Mail::to($application->applicantProfile->user->email)
            ->send(new InterviewCallMail($application, $this->interviewMessage));
        $nomorWhatsapp = $application->applicantProfile->phone_number;
        if (substr($nomorWhatsapp, 0, 2) !== '62') {
    $nomorWhatsapp = '62' . substr($nomorWhatsapp, 1); // Ganti 08... → 628...
        }
        $whatsappUrl = "https://wa.me/{$nomorWhatsapp}?text=" . urlencode("Halo, Anda dipanggil wawancara untuk lowongan {$this->jobName}. Detail: {$this->interviewMessage}");

    } elseif ($this->selectedStatus === 'rejected') {
        Mail::to($application->applicantProfile->user->email)
            ->send(new RejectionMail($application, $this->rejectionReason));
        $nomorWhatsapp = $application->applicantProfile->phone_number;
        if (substr($nomorWhatsapp, 0, 2) !== '62') {
    $nomorWhatsapp = '62' . substr($nomorWhatsapp, 1); // Ganti 08... → 628...
        }
        $whatsappUrl = "https://wa.me/{$nomorWhatsapp}?text=" . urlencode("Mohon maaf, lamaran Anda belum dapat dilanjutkan.");

    } elseif ($this->selectedStatus === 'hired') {
        Mail::to($application->applicantProfile->user->email)
            ->send(new HiredMail($application, $this->offeringLetter));
        $nomorWhatsapp = $application->applicantProfile->phone_number;
        if (substr($nomorWhatsapp, 0, 2) !== '62') {
    $nomorWhatsapp = '62' . substr($nomorWhatsapp, 1); // Ganti 08... → 628...
        }
        $whatsappUrl = "https://wa.me/{$nomorWhatsapp}?text=" . urlencode("Selamat! Anda diterima di posisi {$this->jobName}.\n\n{$this->offeringLetter}");
    }

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

    public function viewExam($applicantProfileId)
    {
        // Ambil semua exam_result dengan relasi application → job
        $this->examResults = ExamResult::with(['application.job'])
            ->whereHas('application', function ($query) use ($applicantProfileId) {
                $query->where('applicant_profile_id', $applicantProfileId);
            })
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
            session()->flash('error', 'Belum ada hasil ujian ditemukan.');
            return;
        }

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
        ])->paginate(10);

        return view('livewire.admin.application-management', [
            'applications' => $applications
        ]);
    }
}
