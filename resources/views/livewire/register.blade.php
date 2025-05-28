<div>
    <form wire:submit.prevent="register">
        <div>
            <label for="email">Email</label>
            <input type="email" wire:model="email" required>
            @error('email') <span>{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="password" wire:model="password" required>
            @error('password') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" wire:model="password_confirmation" required>
            @error('password_confirmation') <span>{{ $message }}</span> @enderror
        </div>

        <button type="submit">Register</button>
    </form>

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>
