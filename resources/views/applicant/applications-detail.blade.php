@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Lamaran</h5>
        </div>
        <div class="card-body">
            <h5 class="card-title mb-2"><strong>Lowongan:</strong> {{ $application->job->name }}</h5>

            <p class="mb-1 card-text"><strong>Diajukan pada:</strong> {{ $application->created_at->format('d F Y') }}</p>

            <p>
                <strong>Status:</strong>
                @if ($application->status === 'applied')
                    <span class="badge badge-warning">Sudah Dilamar</span>
                @elseif ($application->status === 'processed')
                    <span class="badge badge-info">Lamaran Diproses</span>
                @elseif ($application->status === 'hired')
                    <span class="badge badge-success">Anda Diterima</span>
                @else
                    <span class="badge badge-danger">Ditolak</span>
                @endif
            </p>

            @if ($application->offering_letter && $application->status === 'hired')
                <p class="mt-3">
                    <strong>Surat Penawaran:</strong> 
                    <a href="{{ asset('storage/'.$application->offering_letter) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Surat Penawaran</a>
                </p>
            @elseif($application->interview_message && $application->status === 'processed')
                <p class="mt-3">
                    <strong>Pesan Interview:</strong><br>
                    {{ $application->interview_message ?? 'Tidak ada pesan' }}
                </p>
            @elseif($application->rejection_reason && $application->status === 'rejected')
                <p class="mt-3">
                    <strong>Alasan Penolakan:</strong><br>
                    {{ $application->rejection_reason ?? 'Tidak ada' }}
                </p>
            @endif

            <hr>

            <p>
                <strong>CV:</strong> 
                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#cvModal">
                    Lihat CV
                </button>
            </p>
            <small class="text-muted m-3"><i> Silahkan cek e-mail anda secara berkala. Tidak menerima e-mail masuk? Cek folder spam</i></small>
        </div>
    </div>
</div>

<!-- Modal CV -->
<div class="modal fade" id="cvModal" tabindex="-1" role="dialog" aria-labelledby="cvModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cvModalLabel">Preview CV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height: 80vh;">
        <iframe src="{{ asset('storage/'.$application->cv_path) }}" width="100%" height="100%" frameborder="0"></iframe>
      </div>
    </div>
  </div>
</div>
@endsection
