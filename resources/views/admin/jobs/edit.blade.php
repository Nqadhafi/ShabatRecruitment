@extends('layouts.app')

@section('title', 'Edit Job')

@section('content_header')
    <h1>Edit Job</h1>
@stop
@push('css')
        <!-- Link CSS untuk Summernote -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@endpush
@section('content')
    <form action="{{ route('jobs.update', $job) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Job Name</label>
            <input type="text" name="name" class="form-control" value="{{ $job->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{!! $job->description !!}</textarea>
        </div>

        <div class="form-group">
            <label for="requirement">Requirements</label>
            <textarea name="requirement" id="requirement" class="form-control" required>{!! $job->requirement !!}</textarea>
        </div>

        <div class="form-group">
            <label for="photo_path">Upload Logo</label>
            <input type="file" name="photo_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Job</button>
    </form>


    @push('scripts')
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Summernote untuk deskripsi dan persyaratan
            $('#description').summernote({
                height: 200, // Tinggi editor
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
                height: 200, // Tinggi editor
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

        // Menambahkan event listener saat formulir disubmit
        document.querySelector('form').onsubmit = function() {
            // Menyimpan konten editor ke dalam textarea yang tersembunyi
            document.querySelector('textarea[name=description]').value = $('#description').summernote('code');
            document.querySelector('textarea[name=requirement]').value = $('#requirement').summernote('code');
        };
    </script>
    @endpush
@stop
