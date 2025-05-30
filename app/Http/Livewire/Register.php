<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $email, $password, $password_confirmation;

    protected $rules = [
        'email' => 'required|email|regex:/^[\w\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z]{2,}$/|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Kirimkan email verifikasi
        event(new Registered($user));

        session()->flash('message', 'Silakan cek email Anda untuk verifikasi akun.');

        return redirect()->route('verification.notice');
    }

    public function messages()
    {
        return [
            'email.regex' => 'Format email yang kamu masukkan tidak valid. Contoh: user@example.com',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak sesuai.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }

    public function render()
    {
        return view('livewire.register');
    }
}
