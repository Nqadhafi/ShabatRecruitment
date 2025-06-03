@extends('layouts.app')


@section('title', 'Create Job')
@section('content_header')
    <h1>Buat Lowongan Pekerjaan</h1>
@stop
@push('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

@endpush
@section('content')
    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="form-group">
                        <ion-icon name="briefcase" class="align-middle"></ion-icon>
            <label for="name">Nama Lowongan</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
<ion-icon name="time" class="align-middle"></ion-icon>
            <label for="contract">Tipe Pekerjaan</label>
            
            <select name="contract" class="form-control" required>
                <option value="">Pilih Tipe Pekerjaan</option>
                <option value="Full-Time">Full-Time</option>
                <option value="Part-Time">Part-Time</option>
                <option value="Internship">Internship/Magang</option>
        </select>
        </div>

        <div class="form-group">
            <ion-icon name="school" class="align-middle"></ion-icon>
            <label for="min_grades">Minimal Pendidikan</label>
            <select name="min_grades" class="form-control" required>
                <option value="">Pilih Minimal Pendidikan</option>
                @foreach ($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>
                <div class="form-group">
                    <ion-icon name="male-female" class="align-middle"></ion-icon>
            <label for="gender">Jenis Kelamin</label>
            <select name="gender" class="form-control" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Pria">Pria</option>
                <option value="Wanita">Wanita</option>
                <option value="Pria/Wanita">Pria/Wanita</option>
            </select>
        </div>
        <div class="form-group">
            <ion-icon name="document-text" class="align-middle"></ion-icon>
            <label for="description">Deskripsi Pekerjaan</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <ion-icon name="create" class="align-middle"></ion-icon>
            <label for="requirement">Kualifikasi / Persyaratan</label>
            <textarea name="requirement" id="requirement" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="deadline">Batas Waktu Pendaftaran</label>
            <input type="date" name="deadline" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="photo_path">Upload Gambar (Opsional)</label>
            <input type="file" name="photo_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Buat Lowongan</button>
    </form>

<!-- Quill JS untuk Summernote -->
<!-- Link ke jQuery (harus dimuat pertama) -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> --}}
@push('scripts')
<script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons.js"></script>
<script>
    // $(function(){
    //     $('#summernote').summernote()
    // })
    // Inisialisasi Summernote untuk deskripsi dan persyaratan
    $(document).ready(function() {
        $('#description').summernote({
            height: 150, // Atur tinggi editor
            placeholder: 'Masukan deskripsi pekerjaan...<ul><li>Deskripsi 1</li> <li>Deskripsi 2</li><li>dst..</li></ul>',
            toolbar: [
                ['style', ['bold', 'italic']],
                // ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul']],
                ['insert', ['link']],
            ]
        });

        $('#requirement').summernote({
            height: 150, // Atur tinggi editor
            placeholder: 'Masukan persyaratan/kualifikasi...<ul><li>Syarat 1</li> <li>Syarat 2</li><li>dst..</li></ul>',
            toolbar: [
                ['style', ['bold', 'italic']],
                // ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul']],
                ['insert', ['link']],
            ]
        });
    });
</script>
@endpush
    
@stop
