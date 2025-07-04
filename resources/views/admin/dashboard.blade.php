@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1>Halo Bapak/Ibu HRD</h1>
    <p>Selamat datang di portal manajemen recruitment Shabat Printing.</p>
@stop

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pending }}</h3>
                    <p>Lamaran Belum Diproses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{ route('admin.manajemen-lowongan') }}" class="small-box-footer">
                    Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $hired }}</h3>
                    <p>Pelamar Diterima</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('admin.manajemen-lowongan') }}" class="small-box-footer">
                    Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $rejected }}</h3>
                    <p>Lamaran Ditolak</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <a href="{{ route('admin.manajemen-lowongan') }}" class="small-box-footer">
                    Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $activeJobs }}</h3>
                    <p>Lowongan Aktif</p>
                </div>
                <div class="icon">
                    <i class="ion ion-briefcase"></i>
                </div>
                <a href="{{ route('jobs.index') }}" class="small-box-footer">
                    Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Chart & Table -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Statistik Lamaran Per Bulan</h3>
                </div>
                <div class="card-body">
                    <canvas id="applicationChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info">
    <div class="alert alert-warning mt-4">
        <strong>Catatan:</strong> Jika tombol WhatsApp tidak berfungsi, pastikan nomor HP valid atau gunakan WhatsApp Desktop.
    </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lamaran Terbaru</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Pelamar</th>
                                <th>Lowongan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestApplications as $app)
                                <tr>
                                    <td>{{ $app->applicantProfile->full_name ?? '-' }}</td>
                                    <td>{{ $app->job->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $app->status === 'applied' ? 'warning' : 
   ($app->status === 'hired' ? 'success' : 
   ($app->status === 'processed' ? 'info' : 
   ($app->status === 'rejected' ? 'danger' : 'secondary'))) 
}}">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.manajemen-lowongan') }}" class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Shortcut Buttons -->
    <div class="row mt-4 text-center">
        <div class="col-md-12">
            <a href="{{ route('jobs.create') }}" class="btn btn-success mx-2"><i class="fas fa-briefcase"></i> Buat Lowongan Baru</a>
            <a href="{{ route('admin.manajemen-lowongan') }}" class="btn btn-primary mx-2"><i class="fas fa-list"></i> Lihat Semua Lamaran</a>
        </div>
    </div>

    <!-- WhatsApp Error Notice -->


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js "></script>
<script>
const ctx = document.getElementById('applicationChart').getContext('2d');
const applicationChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Jumlah Lamaran',
            data: @json($data),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            lineTension: 0.4 // gunakan lineTension, bukan tension
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

</script>
@endpush