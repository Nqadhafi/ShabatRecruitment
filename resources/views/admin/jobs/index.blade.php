@extends('layouts.app')

@section('title', 'Manage Jobs')

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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Requirement</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
                <tr>
                    <td>{{ $job->name }}</td>
                    <td>{{ Str::limit($job->description, 50) }}</td>
                    <td>{{ Str::limit($job->requirement, 50) }}</td>
                    <td>
                        <span class="badge {{ $job->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $job->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('jobs.edit', $job) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('jobs.destroy', $job) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>

                        <form action="{{ route('admin.jobs.toggle', $job) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ $job->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
