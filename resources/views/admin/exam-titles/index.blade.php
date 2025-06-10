@extends('layouts.app')
@section('page-title', 'Judul Ujian')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Daftar Judul Ujian</h3>
                        @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
                    <a href="{{ route('exam-titles.create') }}" class="btn btn-sm btn-primary float-right">
                        <i class="fas fa-plus"></i> Tambah Judul
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul Ujian</th>
                                <th>Tipe Soal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($examTitles as $title)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $title->title }}</td>
                                    <td>{{ ucfirst($title->exam_type) }}</td>
                                    <td>
                                        @if($title->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('exam-titles.questions.index', $title) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Lihat Soal
                                        </a>
                                        <a href="{{ route('exam-titles.edit', $title) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('exam-titles.destroy', $title) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
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
                    {{ $examTitles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection