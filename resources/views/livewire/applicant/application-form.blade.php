    @push('scripts')
        <script src="{{ asset('app/upload-ui.js') }}"></script>
    @endpush
    @push('css')
        <link rel="stylesheet" href="{{ asset('app/upload-ui.css') }}">
    @endpush
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
                    <label for="cv">Curiculum Vitae (Wajib)</label>
                    <div class="custom-upload">
                        <div class="upload-text" wire:ignore>Click or drag file here to upload (PDF, max 1MB) </div>
                        <input type="file" wire:model="cv" id="cv" class="form-control">
                    </div>
                    @error('cv')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group ">
                    <label for="transkrip">Transkrip Nilai (Wajib)</label>
                    <div class="custom-upload">
                        <div class="upload-text" wire:ignore>Click or drag file here to upload (PDF, max 1MB) </div>
                        <input type="file" wire:model="transkrip" id="transkrip" class="form-control">
                    </div>
                    @error('transkrip')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="pakelaring">Pakelaring / Surat Keterangan Kerja (Opsional)</label>
                    <div class="custom-upload" wire:ignore>
                        <div class="upload-text">Click or drag file here to upload (PDF, max 1MB) </div>
                        <input type="file" wire:model="pakelaring" id="pakelaring" class="form-control">
                    </div>
                    @error('pakelaring')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



                <div class="form-group">
                    <label for="sertifikat">Sertifikat Pendukung (Opsional)</label>
                    <div class="custom-upload">
                        <div class="upload-text" wire:ignore>Click or drag file here to upload (PDF, max 1MB) </div>
                        <input type="file" wire:model="sertifikat" id="sertifikat" class="form-control">
                    </div>
                    @error('sertifikat')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
            </form>
        </div> {{-- In work, do what you enjoy. --}}
    </div>
