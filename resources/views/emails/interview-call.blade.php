<!DOCTYPE html>
<html>
<head>
    <title>Pemanggilan Wawancara</title>
</head>
<body>
    <h3>Halo {{ $application->applicantProfile->full_name }},</h3>

    <p>Anda dipanggil untuk wawancara kerja untuk posisi <strong>{{ $application->job->name }}</strong>.</p>

    <p><strong>Pesan:</strong></p>
    <p>{!! nl2br(e($messageText)) !!}</p>

    <p>Silakan konfirmasi kehadiran Anda.</p>

    <p>Hormat kami,<br>Tim HRD Shabat Printing</p>
</body>
</html>