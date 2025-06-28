@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h4>Riwayat Lamaran</h4>

    @if ($applications->isEmpty())
        <div class="alert alert-info">Belum ada lamaran.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Lowongan</th>
                        <th>Tanggal Lamar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $app)
                        <tr>
                            <td>{{ $app->job->name ?? '-' }}</td>
                            <td>{{ $app->created_at->format('d M Y') }}</td>
                            <td>
                                @if ($app->status === 'applied')
                                    <span class="badge badge-warning">Sudah Dilamar</span>
                                @elseif ($app->status === 'processed')
                                    <span class="badge badge-success">Lamaran Diproses</span>
                                @elseif ($app->status === 'hired')
                                    <span class="badge badge-success">Anda Diterima</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('applicant.application.detail', $app->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection