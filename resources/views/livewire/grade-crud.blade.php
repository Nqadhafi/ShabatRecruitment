{{-- @push('css') --}}

{{-- @endpush --}}
{{-- @push('scripts') --}}
  
{{-- @endpush --}}
{{-- @section('content') --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage Grades</h3>
    </div>
    <div class="card-body">
        <!-- Form untuk Create/Edit -->
        <form wire:submit.prevent="save">
            <div class="form-group">
                <label for="name">Grade Name</label>
                <input type="text" class="form-control" id="name" wire:model="name" placeholder="Enter Grade Name">
            </div>
            <button type="submit" class="btn btn-primary">
                {{ $isEditing ? 'Update' : 'Create' }} Grade
            </button>
        </form>

        <!-- Pesan Feedback -->
        @if($message)
            <div class="alert alert-success mt-3">
                {{ $message }}
            </div>
        @endif

        <!-- Tabel Data Grade -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Grade Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                    <tr>
                        <td>{{ $grade->id }}</td>
                        <td>{{ $grade->name }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" wire:click="edit('{{ $grade->id }}')">Edit</button>
                            <button class="btn btn-danger btn-sm" wire:click="delete('{{ $grade->id }}')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginate Jika Dibutuhkan -->
        {{-- {{ $grades->links() }} --}}
    </div>
</div>
{{-- @endsection --}}
