@extends('layouts.app')

<!-- Link ke Quill CSS versi terbaru -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<style>
    .ql-container{
        height: 10rem;
    }
</style>

@section('title', 'Create Job')

@section('content_header')
    <h1>Create New Job</h1>
@stop

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
            <label for="name">Job Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <div id="editorDescription"></div>
            <textarea name="description" id="description" hidden></textarea>
        </div>

        <div class="form-group">
            <label for="requirement">Requirements</label>
            <div id="editorRequirement"></div>
            <textarea name="requirement" id="requirement" hidden></textarea>
        </div>

        <div class="form-group">
            <label for="photo_path">Upload Logo</label>
            <input type="file" name="photo_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Create Job</button>
    </form>


    <script>
const quillDescription = new Quill('#editorDescription', {
    theme: 'snow'
});

const quillRequirement = new Quill('#editorRequirement', {
    theme: 'snow'
});

// Debugging: Pastikan Quill berhasil diinisialisasi
console.log(quillDescription);
console.log(quillRequirement);

    // Menambahkan event listener saat formulir disubmit
    document.querySelector('form').onsubmit = function(event) {
        // Menyimpan konten editor Quill ke dalam variabel
        const descriptionContent = quillDescription.root.innerHTML;
        const requirementContent = quillRequirement.root.innerHTML;

        // Menugaskan nilai konten ke dalam textarea yang tersembunyi
        document.querySelector('textarea[name=description]').value = descriptionContent;
        document.querySelector('textarea[name=requirement]').value = requirementContent;

        // Debug: Menampilkan konten yang disalin ke textarea
        console.log('Description Content:', descriptionContent);
        console.log('Requirement Content:', requirementContent);

        // Menangani validasi jika field kosong
        if (!descriptionContent.trim() || !requirementContent.trim()) {
            alert('Deskripsi dan Persyaratan tidak boleh kosong!');
            event.preventDefault(); // Mencegah formulir disubmit jika kosong
        }
    };
    </script>
@stop
