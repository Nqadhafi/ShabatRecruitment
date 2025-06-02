@push('css')
       <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons.js"></script>
@endpush
<div class="row">
    <!-- Panel Kiri - Daftar Lowongan -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Daftar Lowongan</div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($jobs as $job)
                <li class="list-group-item" wire:ignore>
                    <h6 class="card-title font-weight-bold mb-1 text-blue">{{ $job->name }}</h6>
                    <div class="card-text align-items-center d-flex">
                        <ion-icon name="bookmark" class="mr-1"></ion-icon>
                        <small>Shabat Printing</small>
                    </div>
                    <div class="card-text align-items-center d-flex mb-1">
                        <ion-icon name="pin" class="mr-1"></ion-icon>
                        <small class="text-muted">Laweyan,Surakarta</small>
                    </div>
                    <ul class="card-text px-3">
                        <li><small>Berpenampilan menarik</small></li>
                        <li><small>Berpenampilan menarik</small></li>
                        <li><small>Berpenampilan menarik</small></li>
                    </ul>
                    <p class="text-muted text-center m-0">
                    <small >Batas Waktu : 31 Februari 2025</small>
                    </p>
                        <a wire:click.prevent="selectJob('{{ $job->id }}')" class="stretched-link"></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Panel Kanan - Detail Lowongan -->
    <div class="col-md-8">
        @if ($selectedJob)
            <div class="card">
                <div class="card-header">Detail Lowongan</div>
                <div class="card-body">
                    <h5>{{ $selectedJob->name }}</h5>
                    <p><strong>Lokasi:</strong> {{ $selectedJob->requirement }}</p>
                    <p>{{ $selectedJob->description }}</p>
                </div>
            </div>
        @else
            <p>Silakan pilih lowongan untuk melihat detailnya.</p>
        @endif
    </div>
</div>
