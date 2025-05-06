@extends('layouts.app')


@section('title', 'Create Job')

@section('content_header')
    <h1>Create New Job</h1>
@stop
@push('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
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
            <label for="name">Job Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="requirement">Requirements</label>
            <textarea name="requirement" id="requirement" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="photo_path">Upload Logo</label>
            <input type="file" name="photo_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Create Job</button>
    </form>

<!-- Quill JS untuk Summernote -->
<!-- Link ke jQuery (harus dimuat pertama) -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> --}}
@push('scripts')
<script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    // $(function(){
    //     $('#summernote').summernote()
    // })
    // Inisialisasi Summernote untuk deskripsi dan persyaratan
    $(document).ready(function() {
        $('#description').summernote({
            height: 200, // Atur tinggi editor
            placeholder: 'Enter job description here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
            ]
        });

        $('#requirement').summernote({
            height: 200, // Atur tinggi editor
            placeholder: 'Enter job requirements here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
            ]
        });
    });
</script>
@endpush
    
@stop
