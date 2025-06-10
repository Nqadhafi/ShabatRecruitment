@extends('layouts.app')
@section('page-title', 'Import Soal Ujian')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Import Soal - {{ $examTitle->title }}</h3>
                </div>
                <form action="{{ route('admin.exam-questions.import.store', $examTitle) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="file">Upload File Excel (.xlsx)</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                        <a href="{{ route('admin.exam-questions.index', $examTitle) }}" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection