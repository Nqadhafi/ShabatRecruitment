@extends('layouts.app')
@section('page-title', 'Edit Soal Ujian')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Soal</h3>
                </div>
                <form action="{{ route('exam-questions.update', [$examTitle, $examQuestion]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @include('admin.exam-questions._form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="{{ route('exam-questions.index', $examTitle) }}" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection