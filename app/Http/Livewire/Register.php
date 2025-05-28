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
        'email' => 'required|email|unique:users,email',
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

    public function render()
    {
        return view('livewire.register');
    }
}
