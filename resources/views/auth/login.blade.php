@extends('layouts.app')

@section('title', 'Login')

@section('content_header')
    <h1>Login</h1>
@stop

@section('content')
    <form action="{{ url('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
@stop
