@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">Edit Profil</div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('applicant.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Lengkap -->
                <div class="form-group mb-3">
                    <div class="form-group mb-3">
                        <label>E-mail</label>
                        <input type="text" readonly class="form-control"
                            value="{{ Auth::user()->email }}">
                        <input type="hidden" name="ktp_number"
                            value="{{ Auth::user()->email }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Nomor KTP</label>
                        <input type="text" readonly class="form-control"
                            value="{{ old('ktp_number', $applicantProfile->ktp_number) }}">
                        <input type="hidden" name="ktp_number"
                            value="{{ old('ktp_number', $applicantProfile->ktp_number) }}">
                    </div>
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" class="form-control"
                        value="{{ old('full_name', $applicantProfile->full_name) }}">
                </div>

                <!-- Nama Panggilan -->
                <div class="form-group mb-3">
                    <label>Nama Panggilan</label>
                    <input type="text" name="surname" class="form-control"
                        value="{{ old('surname', $applicantProfile->surname) }}">
                </div>

                <!-- KTP Number (readonly) -->

                <!-- Alamat -->
                <div class="form-group mb-3">
                    <label>Alamat</label>
                    <textarea name="address" class="form-control">{{ old('address', $applicantProfile->address) }}</textarea>
                </div>

                <!-- No HP -->
                <div class="form-group mb-3">
                    <label>No Telepon</label>
                    <input type="text" name="phone_number" class="form-control"
                        value="{{ old('phone_number', $applicantProfile->phone_number) }}">
                </div>

                <!-- Foto Profil -->
                <div class="form-group text-center mb-4">
                    <label>Foto Profil</label><br>

                    @if ($applicantProfile->photo_path)
                        <img src="{{ asset('storage/' . $applicantProfile->photo_path) }}"
                             id="preview-photo"
                             class="img-thumbnail mb-2"
                             style="width: 150px; height: auto;">
                    @else
                        <div class="d-inline-block img-thumbnail mb-2"
                             id="preview-photo"
                             style="width: 150px; height: 150px; line-height: 150px; text-align: center;">
                            <span class="text-muted">Belum ada foto</span>
                        </div>
                    @endif

                    <input type="file" name="photo" id="photo" accept="image/*" class="form-control mt-2"
                           onchange="previewImage(event)">
                </div>

                <!-- Tombol -->
                <a href="{{ route('applicant.dashboard') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-photo');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        } else {
            alert('Silakan pilih file gambar (JPG/PNG).');
            event.target.value = ''; // Reset input
            preview.src = '{{ $applicantProfile->photo_path ? asset("storage/".$applicantProfile->photo_path) : "" }}';
        }
    }
</script>
@endpush