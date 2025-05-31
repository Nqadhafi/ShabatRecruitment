<!-- resources/views/auth/verification.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifikasi E-mail Anda') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('E-mail verifikasi berhasil dikirim ulang, cek kembali e-mail anda.') }}
                        </div>
                    @endif

                    {{ __('Sebelum melanjutkan, cek e-mail anda untuk mengaktifkan akun anda.') }}
                        <br>
                    {{ __('Tidak menerima e-mail? Cek folder spam anda. Atau') }},
                    <form class="d-inline" method="POST" action="">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('klik di sini untuk kirim ulang e-mail verifikasi') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
