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
        <div class="text-center">
        <div wire:loading wire:target="save">
            <div><i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
                <div class="text-bold pt-2">Loading...</div>
        </div>
    </div>
        <div class="text-center">
        <div wire:loading wire:target="delete">
            <div><i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
                <div class="text-bold pt-2">Loading...</div>
        </div>
    </div>
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
                        <button class="btn btn-danger btn-sm" wire:click="confirmDelete('{{ $grade->id }}')">Delete</button>
                    </td>
                </tr>
            @endforeach
            
            </tbody>
        </table>
<!-- Modal untuk konfirmasi penghapusan -->
<!-- Modal untuk konfirmasi penghapusan -->
<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this grade?</p>
            </div>
            <div class="modal-footer">
                <!-- Tombol Cancel -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Cancel</button>
                <!-- Tombol Yes, Delete -->
                <button type="button" class="btn btn-danger" wire:click="delete">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        const modalElement = document.getElementById('deleteModal');
        const deleteModal = new bootstrap.Modal(modalElement);

        Livewire.on('openDeleteModal', () => deleteModal.show());
        Livewire.on('closeDeleteModal', () => deleteModal.hide());
    });
    </script>

        <!-- Paginate Jika Dibutuhkan -->
        {{-- {{ $grades->links() }} --}}
    </div>
</div>


{{-- @endsection --}}
