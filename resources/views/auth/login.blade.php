@extends('layouts.home')

@section('title', 'Login')


@section('home-content')
<div class="bg-light m-0 p-5">
    <form action="{{ url('login') }}" method="POST" class="login-form  mx-auto border rounded-lg p-5 bg-white" style="max-width: 25rem;" onsubmit="showLoading()">
        <div class="text-center">
        <img src="{{ asset('app/img/Logo_square.png')}}" class="img-fluid text-center mb-2" alt="" style="max-width: 5rem;">
        <h3 class="text-center mb-5">E-recruitment Login</h3>
        </div>
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
@endif
        @csrf
        <div class="form-group">
            <label for="email" class="text-muted">Email:</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="password" class="text-muted">Password:</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
                <div>
        {!! NoCaptcha::display() !!}
@if ($errors->has('g-recaptcha-response'))
    <span class="text-danger">
        <small>{{ $errors->first('g-recaptcha-response') }}</small>
    </span>
@endif
</div>
<div class="form-group text-center">
    <button type="submit" class="btn btn-primary my-3">Masuk</button>
</div>
<div class="form-group p-0 m-0 text-center">
    <a href="{{ route('register') }}"><small>Belum punya akun? Daftar sekarang</small></a>
</div>
    </form>
    <div id="loading" class="loading-overlay" style="display: none;">
        <div class="loading-content">
            <img src="{{ asset('app/img/loading.gif') }}" alt="Loading..." style="width: 8rem;">
            <p>Loading...</p>
        </div>
    </div>
    </div>
        @push('home-scripts')
         {!! NoCaptcha::renderJs() !!}
    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'flex';
        }
    </script>
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .loading-content {
            text-align: center;
        }
    </style>
    @endpush
@stop
