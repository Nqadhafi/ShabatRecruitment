<!DOCTYPE html>
<html>
<head>
    <title>Status Lamaran</title>
</head>
<body>
    <p>Halo {{ $application->applicantProfile->full_name }},</p>

    <p>Kami informasikan bahwa lamaran Anda untuk posisi <strong>{{ $application->job->name }}</strong> tidak lolos seleksi.</p>

    <p><strong>Alasan Penolakan:</strong></p>
    <p>{!! nl2br(e($reason)) !!}</p>

    <p>Terima kasih atas minat dan waktu Anda.</p>

    <p>Hormat kami,<br>Tim HRD Shabat Printing</p>
</body>
</html>