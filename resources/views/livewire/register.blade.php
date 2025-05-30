<div class="bg-light m-0 p-5">
    <form wire:submit.prevent="register" class="register-form  mx-auto border rounded-lg p-5 bg-white" style="max-width: 25rem;">
        <div class="text-center">
        <img src="{{ asset('app/img/Logo_square.png')}}" class="img-fluid text-center mb-2" alt="" style="max-width: 5rem;">
        <h3 class="text-center mb-5">E-recruitment Daftar</h3>
        </div>
        <div class="mb-3">
            <label for="email" class="text-muted">Email</label>
            <input type="email" wire:model="email" class="form-control" required placeholder="emailanda@gmail.com">
            @error('email') <small class="form-text text-danger">{{ $message }}</small> @enderror
        </div>
        
        <div class="mb-3">
            <label for="password" class="text-muted">Password</label>
            <input type="password" wire:model="password" class="form-control" required placeholder="Password">
            @error('password') <small class="form-text text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="text-muted">Konfirmasi Password</label>
            <input type="password" wire:model="password_confirmation" class="form-control" required placeholder="Password">
            @error('password_confirmation') <small class="form-text text-danger"> {{ $message }}</small> @enderror
        </div>
        <div class="text-center">
        <button type="submit" class="btn btn-primary my-3">Daftar</button>
        </div>
    </form>

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>
