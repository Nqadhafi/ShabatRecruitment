@extends('layouts.app')

@section('title', 'Dashboard Pelamar')

@section('content_header')
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
    <h1>Welcome to Applicant Dashboard</h1>
@stop

@section('content')

    <p>Pelamar dashboard content here.</p>
@stop
