@extends('layouts.app')
@section('page-title', 'Import Soal Ujian')
@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <div class="row">
<div class="alert alert-info">
    <strong>Panduan Format Excel:</strong><br>
    - Kolom wajib: <code>soal</code>, <code>a</code>, <code>b</code>, <code>c</code>, <code>d</code><br>
    - Untuk tambahan jawaban, tambahkan kolom <code>e</code>, <code>f</code>, dst.<br>

    @if($examTitle->exam_type === 'benar_salah')
        - Wajib isi <code>jawaban_benar</code> (boleh E/F/G...)
    @else
        - Wajib isi semua poin (termasuk <code>poin_e</code>, <code>poin_f</code>, dst.)
    @endif
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