@extends('layouts.app')
@section('page-title', 'Import Soal Ujian')
@section('content')
    <div class="row">
<div class="alert alert-info">
    <strong>Panduan Format Excel:</strong><br>
    Kolom wajib: <code>soal</code>, <code>a</code>, <code>b</code>, <code>c</code>, <code>d</code><br>

    @if($examTitle->exam_type === 'benar_salah')
        Tipe ujian <strong>Benar/Salah</strong>: tambahkan kolom <code>jawaban_benar</code><br>
    @else
        Tipe ujian <strong>Poin</strong>: tambahkan kolom <code>poin_a</code>, <code>poin_b</code>, dll.<br>
    @endif

    <small>Nama kolom harus lowercase tanpa spasi (misal: <code>jawaban_benar</code>)</small>
</div>
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Import Soal - {{ $examTitle->title }}</h3>
                </div>
                <form action="{{ route('exam-questions.import.store', $examTitle) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="file">Upload File Excel (.xlsx)</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                        <a href="{{ route('exam-questions.index', $examTitle) }}" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection