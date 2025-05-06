<div class="mb-1">
    <button wire:click="toggleStatus" class="btn btn-sm {{ $job->is_active ? 'btn-danger' : 'btn-success' }}" onclick="event.stopPropagation();">
        {{ $job->is_active ? 'Non-aktifkan Lowongan Ini' : 'Aktifkan Lowongan Ini' }}
    </button>
</div>

