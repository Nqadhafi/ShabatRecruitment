@extends('layouts.home')

@section('title', 'Login')


@section('home-content')
<div class="bg-light m-0 p-5">
    <form action="{{ url('login') }}" method="POST" class="login-form  mx-auto border rounded-lg p-5 bg-white" style="max-width: 25rem;">
        <div class="text-center">
        <img src="{{ asset('app/img/Logo_square.png')}}" class="img-fluid text-center mb-2" alt="" style="max-width: 5rem;">
        <h3 class="text-center mb-5">E-recruitment Login</h3>
        </div>
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
        <div class="form-group p-0 m-0">
            <a href="{{ route('register') }}"><small>Belum punya akun? Daftar sekarang</small></a>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary my-3">Masuk</button>
        </div>
    </form>
    </div>
@stop
