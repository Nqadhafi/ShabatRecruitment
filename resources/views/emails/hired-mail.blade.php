<!DOCTYPE html>
<html>
<head>
    <title>Lamaran Diterima!</title>
</head>
<body>
    <p>Halo {{ $application->applicantProfile->full_name }},</p>

    <p>Selamat! Anda telah diterima untuk posisi <strong>{{ $application->job->name }}</strong>.</p>

    <p><strong>Offering Letter:</strong></p>
    <p>{!! nl2br(e($letter)) !!}</p>

    <p>Silakan hubungi kami untuk konfirmasi lebih lanjut.</p>

    <p>Hormat kami,<br>Tim HRD Shabat Printing</p>
</body>
</html>