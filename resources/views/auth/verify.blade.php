<!-- resources/views/auth/verification.blade.php -->
@extends('layouts.home')

@section('home-content')
<div class="container p-5 m-5 mx-auto">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif
                <div class="card-header">{{ __('Verifikasi Email Anda') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Tautan verifikasi baru telah dikirimkan ke email Anda.') }}
                        </div>
                    @endif

                    <p>{{ __('Sebelum melanjutkan, harap verifikasi email Anda dengan mengklik tautan yang telah kami kirimkan ke email Anda.') }}</p>

                    <p class="">
                        {{ __('Jika Anda tidak menerima email') }},
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik di sini untuk meminta tautan verifikasi baru') }}</button>
                        </form>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="p-5 m-5">
<div class="p-4 m-4">

</div>
</div>
@endsection
