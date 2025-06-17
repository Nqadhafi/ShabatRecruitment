<div>
   <div class="container mt-4">
    <h4>Upload Dokumen Lamaran</h4>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="card mb-3">
            <div class="card-header">Lowongan: {{ $job->name }}</div>
            <div class="card-body">
                <p><strong>Deskripsi:</strong> {!! $job->description !!}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="cv">CV (PDF, max 2MB)</label>
            <input type="file" wire:model="cv" id="cv" class="form-control">
            @error('cv') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="pakelaring">Pakelaring (PDF, max 2MB)</label>
            <input type="file" wire:model="pakelaring" id="pakelaring" class="form-control">
            @error('pakelaring') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="transkrip">Transkrip Nilai (PDF, max 2MB) (Opsional)</label>
            <input type="file" wire:model="transkrip" id="transkrip" class="form-control">
            @error('transkrip') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="sertifikat">Sertifikat Pendukung (PDF, max 2MB) (Opsional)</label>
            <input type="file" wire:model="sertifikat" id="sertifikat" class="form-control">
            @error('sertifikat') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
    </form>
</div> {{-- In work, do what you enjoy. --}}
</div>
