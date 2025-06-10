@extends('layouts.app')
@section('page-title', 'Tambah Judul Ujian')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Judul Ujian</h3>
                </div>
                <form action="{{ route('exam-titles.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @include('admin.exam-titles._form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('exam-titles.index') }}" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection