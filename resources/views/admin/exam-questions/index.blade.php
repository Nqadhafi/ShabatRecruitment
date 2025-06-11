@extends('layouts.app')
@section('page-title', 'Daftar Soal Ujian')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                                            @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
                    <h3 class="card-title">Soal untuk: <strong>{{ $examTitle->title }}</strong></h3>
                    <a href="{{ route('exam-questions.create', $examTitle) }}" class="btn btn-sm btn-primary float-right">
                        <i class="fas fa-plus"></i> Tambah Soal
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Soal</th>
                                <th>Jawaban Benar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{!! Str::limit($question->question_text, 50) !!}</td>
                                    <td>
                                        @if($examTitle->exam_type === 'benar_salah')
                                            {{ $question->correct_answer }}
                                        @else
                                            <span class="badge badge-info">Tipe Poin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('exam-questions.edit', [$examTitle, $question]) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('exam-questions.destroy', [$examTitle, $question]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus soal ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection