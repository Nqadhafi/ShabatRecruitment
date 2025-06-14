@extends('layouts.home')
@section('title', 'Terima Kasih - Shabat Rekrutmen')

@section('home-content')
    <div class="container mt-5 text-center">
        <h4>Terima Kasih!</h4>
        <p>Anda telah menyelesaikan seluruh rangkaian ujian.</p>
        <p>Silakan tunggu konfirmasi selanjutnya via email atau WhatsApp.</p>
        <a href="{{ route('applicant.dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
@endsection