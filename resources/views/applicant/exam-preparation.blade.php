@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            
        @endif
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Petunjuk Pengerjaan Ujian</h4>
            </div>
            <div class="card-body">
                <p><strong>Halo {{ Auth::user()->applicantProfile->full_name ?? 'Pelamar' }},</strong></p>

                <p>Sebelum memulai ujian online, harap baca petunjuk berikut:</p>

                <ul>
                    <li>Ujian bersifat wajib. Anda tidak bisa keluar sebelum menyelesaikan semua soal.</li>
                    <li>Pastikan memiliki koneksi internet yang stabil.</li>
                    <li>Gunakan browser terkini seperti Google Chrome/Mozilla Firefox.</li>
                    <li>Silahkan kerjakan soal yang paling mudah dulu, anda bisa kembali ke soal yang belum terjawab dengan klik nomor soal yang ada di bawah.</li>
                    <li>Pastikan menjawab setiap soal, tidak menjawab soal akan menghasilkan nilai 0.</li>
                    <li>Setiap sesi ujian memiliki durasi yang berbeda.</li>
                    <li>Jika waktu habis, sistem akan otomatis mengirim jawaban Anda.</li>
                    <li>Nilai ujian akan tersimpan dan digunakan untuk seleksi tahap selanjutnya.</li>
                </ul>

                <hr>

                @foreach ($examTitles as $title)
                    <div class="alert alert-info mb-3">
                        <h6><strong>{{ $loop->iteration }}. {{ $title->title }}</strong></h6>
                        <p>{{ $title->description }}</p>
                        <p><strong>Durasi:</strong> {{ $title->duration_minutes }} menit</p>
                        <p><strong>Jumlah Soal:</strong> {{ $title->questions_count }}</p>
                    </div>
                @endforeach

                <div class="text-center mt-4">
                    <form id="startExamForm" action="{{ route('applicant.exam.start') }}" method="GET">
                        <div class="form-check mb-3">
                            <input type="checkbox" name="agree" id="agreeCheckbox" class="form-check-input" required>
                            <label for="agreeCheckbox" class="form-check-label">
                                Saya setuju mengikuti aturan ujian dan siap memulai.
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg" disabled id="startExamBtn">
                            Mulai Ujian
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('agreeCheckbox');
            const button = document.getElementById('startExamBtn');

            checkbox.addEventListener('change', function() {
                button.disabled = !checkbox.checked;
            });
        });
    </script>
@endpush
