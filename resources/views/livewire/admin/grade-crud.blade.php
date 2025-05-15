<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage Grades</h3>
    </div>
    <div class="card-body">
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
        <button class="btn btn-primary mb-3" wire:click="create">Add New Grade</button>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Grade Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->name }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" wire:click="edit('{{ $grade->id }}')">Edit</button>
                        <button class="btn btn-danger btn-sm" wire:click="confirmDelete('{{ $grade->id }}')">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal untuk Create/Edit dan Delete -->
        <div wire:ignore.self class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            @if($modalType == 'create' || $modalType == 'edit')
                                {{ $isEditing ? 'Edit' : 'Create' }} Grade
                            @elseif($modalType == 'delete')
                                Confirm Deletion
                            @endif
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        @if($modalType == 'create' || $modalType == 'edit')
                            <!-- Form untuk Create/Edit Grade -->
                            <form wire:submit.prevent="save">
                                <div class="form-group">
                                    <label for="name">Grade Name</label>

                                    @error('name')
                                        <div class="alert alert-danger mt-3">
                                            <span class="error">{{ $message }}</span> 
                                        </div>
                                    @enderror
                                    <input type="text" class="form-control" id="name" wire:model="name" placeholder="Enter Grade Name">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEditing ? 'Update' : 'Create' }} Grade
                                </button>
                            </form>
                        @elseif($modalType == 'delete')
                            <!-- Konfirmasi Delete -->
                            <p>Are you sure you want to delete this grade?</p>
                            <button type="button" class="btn btn-danger" wire:click="delete">Yes, Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Cancel</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('livewire:load', function () {
                const modalElement = document.getElementById('gradeModal');
                const gradeModal = new bootstrap.Modal(modalElement);

                Livewire.on('openModal', (type) => {
                    @this.modalType = type;  // Set the modal type dynamically
                    gradeModal.show();
                });

                Livewire.on('closeModal', () => gradeModal.hide());
            });
        </script>
    </div>
</div>
