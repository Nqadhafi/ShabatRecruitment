@livewireStyles
@livewireScripts

@extends('layouts.app')
@section('content')

    @livewire('applicant.application-form', ['jobId' => $jobId])

@endsection