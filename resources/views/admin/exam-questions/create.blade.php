@extends('layouts.app')
@section('page-title', 'Tambah Soal Ujian')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Soal</h3>
                </div>
                <form action="{{ route('exam-questions.store', $examTitle) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @include('admin.exam-questions._form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('exam-questions.index', $examTitle) }}" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection