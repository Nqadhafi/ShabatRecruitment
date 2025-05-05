@extends('layouts.app')

@section('title', 'Edit Job')

@section('content_header')
    <h1>Edit Job</h1>
@stop

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
            <div id="editorDescription">{!! $job->description !!}</div>
            <textarea name="description" id="description" hidden></textarea>
        </div>

        <div class="form-group">
            <label for="requirement">Requirements</label>
            <div id="editorRequirement">{!! $job->requirement !!}</div>
            <textarea name="requirement" id="requirement" hidden></textarea>
        </div>

        <div class="form-group">
            <label for="photo_path">Upload Logo</label>
            <input type="file" name="photo_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Job</button>
    </form>

    <script>
        var quillDescription = new Quill('#editorDescription', {
            theme: 'snow'
        });

        var quillRequirement = new Quill('#editorRequirement', {
            theme: 'snow'
        });

        document.querySelector('form').onsubmit = function() {
            document.querySelector('textarea[name=description]').value = quillDescription.root.innerHTML;
            document.querySelector('textarea[name=requirement]').value = quillRequirement.root.innerHTML;
        };
    </script>
@stop
