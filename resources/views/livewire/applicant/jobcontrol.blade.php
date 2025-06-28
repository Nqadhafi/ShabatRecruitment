<div>@push('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush
@push('scripts')
<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule="" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@endpush
            @if (session()->has('error'))
                <div class="alert alert-warning">{{ session('error') }}</div>
            @endif
<div class="row">
    <!-- Panel Kiri - Daftar Lowongan -->

    <div class="col-md-4">
        <div class="card ">
            <div class="card-header">Daftar Lowongan</div>
            <div class="card-body overflow-auto" style="max-height: 50rem;">
                <ul class="list-group ">
                    @foreach ($jobs as $job)
                        <li class="list-group-item" wire:ignore>
                             <!-- Badge Sudah Dilamar -->
    @if (in_array($job->id, $applications))
        <span class="badge badge-success position-absolute"
              style="top: 10px; right: 10px;">
            Sudah Dilamar
        </span>
    @endif
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
                                <li><small>{{ $job->contract }}</small></li>
                                <li><small>{{ $job->gender }}</small></li>
                                <li><small>Minimal pendidikan {{ $job->grade->name }}</small></li>
                            </ul>
                            <p class="text-muted text-center m-0">

                                <small>Batas Waktu :
                                    {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') }}</small>
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
                    <p><strong>Deskripsi Pekerjaan:</strong>{!! $selectedJob->description !!}</p>
                    <p><strong>Persyaratan:</strong> {!! $selectedJob->requirement !!}</p>
                    <button wire:click="applyNow" class="btn btn-success">Lamar Sekarang!</button>
                </div>
            </div>
        @else
            <p>Silakan pilih lowongan untuk melihat detailnya.</p>
        @endif
        @if ($showConfirmModal)
            <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <p>{{ $confirmMessage }}</p>
                        </div>
                        <div class="modal-footer">
                            @if ($canApply)
                                <button wire:click="confirmApply" class="btn btn-primary">Ya, Lamar</button>
                            @endif
                            <button wire:click="$set('showConfirmModal', false)"
                                class="btn btn-secondary">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif
    </div>
</div>
</div>
