<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage Majority</h3>
    </div>
    <div class="card-body">
        @if(session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <button class="btn btn-primary mb-3" wire:click="create">Add New Majority</button>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Majority Name</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($majorities as $majority)
                <tr>
                    <td>{{ $majority->name }}</td>
                    <td>{{ $majority->grade->name }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" wire:click="edit('{{ $majority->id }}')">Edit</button>
                        <button class="btn btn-danger btn-sm" wire:click="confirmDelete('{{ $majority->id }}')">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal untuk Create/Edit dan Delete -->
        <div wire:ignore.self class="modal fade" id="majorityModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            @if($modalType == 'edit' || $modalType == 'create')
                                {{ $isEditing ? 'Edit' : 'Create' }} Majority
                            @else
                                Confirm Deletion
                            @endif
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        @if($modalType == 'edit' || $modalType == 'create')
                            <!-- Form untuk Create/Edit Majority -->
                            <form wire:submit.prevent="save">
                                <div class="form-group">
                                    <label for="name">Majority Name</label>
                                    @error('name') <div class="alert alert-danger mt-3">{{ $message }}</div> @enderror
                                    <input type="text" class="form-control" id="name" wire:model="name" placeholder="Enter Majority Name">
                                </div>

                                <div class="form-group mt-3">
                                    <label for="grade_uuid">Grade</label>
                                    @error('grade_uuid') <div class="alert alert-danger mt-3">{{ $message }}</div> @enderror
                                    <select class="form-control" id="grade_uuid" wire:model="grade_uuid">
                                        <option value="">Select Grade</option>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">{{ $isEditing ? 'Update' : 'Create' }} Majority</button>
                            </form>
                        @elseif($modalType == 'delete')
                            <!-- Konfirmasi Delete -->
                            <p>Are you sure you want to delete this majority?</p>
                            <button type="button" class="btn btn-danger" wire:click="delete">Yes, Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Cancel</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('livewire:load', function () {
                const modalElement = document.getElementById('majorityModal');
                const majorityModal = new bootstrap.Modal(modalElement);

                Livewire.on('openModal', (type) => {
                    @this.modalType = type;  // Set the modal type dynamically
                    majorityModal.show();
                });

                Livewire.on('closeModal', () => majorityModal.hide());
            });
        </script>
    </div>
</div>
