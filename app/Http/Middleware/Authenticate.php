<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (session()->has('registration_success')) {
                session()->flash('registration_success', 'Registrasi sukses, silakan cek email Anda untuk verifikasi akun.');
            } else {
                session()->flash('verification_message', 'Verifikasi email berhasil, silahkan login untuk melanjutkan.');
            }
            return route('login');
        }
    }
}
