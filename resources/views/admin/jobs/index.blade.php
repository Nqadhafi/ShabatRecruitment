@extends('layouts.app')

@section('title', 'Manage Jobs')
@push('css')
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
@section('content_header')
    <h1>Manage Jobs</h1>
@stop

@section('content')
    <a href="{{ route('jobs.create') }}" class="btn btn-primary mb-3">Create New Job</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="jobsTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Deskripsi Pekerjaan</th>
                <th>Persyaratan</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
                <tr class="clickable-row" data-toggle="modal" data-target="#jobModal{{ $job->id }}">
                    <td>{{ $job->name }}</td>
                    <td>{!! Str::limit($job->description, 20) !!}</td>
                    <td>{!! Str::limit($job->requirement, 20) !!}</td>
                    <td>
                         <!-- Badge Status akan diperbarui secara reaktif menggunakan Livewire -->
                         <span id="statusBadge{{ $job->id }}" class="badge {{ $job->is_active ? 'badge-success' : 'badge-warning' }} p-2">
                            {{ $job->is_active ? 'Lowongan Aktif' : 'Lowongan Non-aktif' }}
                        </span>
                    </td>
                    <td>
                     <!-- Livewire Toggle Button -->
                        @livewire('job-status-toggle', ['job' => $job])
                        <a href="{{ route('jobs.edit', $job) }}" class="btn btn-warning btn-sm" 
                           onclick="event.stopPropagation();">Edit</a>
    
                        <form action="{{ route('jobs.destroy', $job) }}" method="POST" style="display:inline;" 
                              onclick="event.stopPropagation();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDeletion()">Delete</button>
                        </form>

                    </td>
                </tr>
    
                <!-- Modal untuk menampilkan rincian job -->
                <div class="modal fade" id="jobModal{{ $job->id }}" tabindex="-1" aria-labelledby="jobModalLabel{{ $job->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="jobModalLabel{{ $job->id }}">{{ $job->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <strong>Deskripsi Pekerjaan:</strong>
                                <p>{!! $job->description !!}</p>
    
                                <strong>Persyaratan:</strong>
                                <p>{!! $job->requirement !!}</p>
    
                                <strong>Image:</strong>
                                @if ($job->photo_path)
                                    <img src="{{ Storage::url($job->photo_path) }}" alt="Job Logo" width="150">
                                @else
                                    <p>No logo available.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    @push('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    @livewireStyles
@livewireScripts

    <script>
            function confirmDeletion() {
        return confirm('Apakah anda yakin?');  // Jika "Cancel" diklik, return false dan form tidak terkirim
    }
    $(document).ready(function() {
            // Inisialisasi DataTable
            $('#jobsTable').DataTable({
                "paging": true, // Mengaktifkan pagination
                "searching": false, // Mengaktifkan pencarian
                "ordering": true, // Mengaktifkan sorting
                "order": [[ 0, 'asc' ]] // Default sorting berdasarkan kolom pertama (name)
            });
        });
    Livewire.on('jobStatusUpdated', (jobId, isActive) => {
            // Update status badge
            const badge = document.getElementById(`statusBadge${jobId}`);
            badge.classList.toggle('badge-success', isActive);
            badge.classList.toggle('badge-warning', !isActive);
            badge.innerText = isActive ? 'Lowongan Aktif' : 'Lowongan Non-aktif';
        });
    </script>
        
    @endpush
@stop
