

@extends('layouts.app')
@section('content')
<h5>Lowongan: {{ $application->job->name }}</h5>
<p><strong>Diajukan pada:</strong> {{ $application->created_at->format('d F Y') }}</p>
<p><strong>Status:</strong> 
                                @if ($application->status === 'applied')
                                    <span class="badge badge-warning">Sudah Dilamar</span>
                                @elseif ($application->status === 'processed')
                                    <span class="badge badge-success">Lamaran Diproses</span>
                                @elseif ($application->status === 'hired')
                                    <application class="badge badge-success">Anda Diterima</application>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
</p>

<a href="{{ asset('storage/'.$application->cv_path) }}" target="_blank">Lihat CV</a>

@endsection