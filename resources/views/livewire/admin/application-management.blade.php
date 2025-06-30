<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="container-fluid mt-4">
        <h4>Daftar Lamaran</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nama Pelamar</th>
                        <th>Lowongan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $app)
                        <tr>
                            <td>{{ $app->applicantProfile->full_name ?? '-' }}</td>
                            <td>{{ $app->job->name ?? '-' }}</td>
                            <td>
                                <button wire:click="viewProfile('{{ $app->applicant_profile_id }}')"
                                    class="btn btn-sm btn-primary">
                                    Lihat Profil
                                </button>
                                <button wire:click="viewDocuments('{{ $app->applicant_profile_id }}')"
                                    class="btn btn-sm btn-secondary">
                                    Lihat Dokumen
                                </button>
                                <button wire:click="viewExam('{{ $app->applicant_profile_id }}')"
                                    class="btn btn-sm btn-info">
                                    Hasil Ujian
                                </button>
                                <button class="btn btn-sm btn-warning">Proses Lamaran</button>
                                <button class="btn btn-sm btn-success">Download Profil</button>
                                <button class="btn btn-sm btn-dark">Download Berkas</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Profil -->
        @if ($showProfileModal && $selectedProfile)
            <div class="modal fade show d-block" id="profileModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Profil Pelamar</h5>
                            <button type="button" class="close" wire:click="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <!-- Data Umum -->
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    @if ($selectedProfile->photo_path)
                                        <img src="{{ asset('storage/' . $selectedProfile->photo_path) }}"
                                            alt="Foto Profil" style="width: 120px; height: auto;" class="img-thumbnail">
                                    @else
                                        <div class="text-muted mb-3">Belum ada foto</div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Nama:</strong>
                                            {{ $selectedProfile->full_name }}</li>
                                        <li class="list-group-item"><strong>Panggilan:</strong>
                                            {{ $selectedProfile->surname ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Email:</strong>
                                            {{ $selectedProfile->user->email ?? '-' }}</li>
                                        <li class="list-group-item"><strong>No. KTP:</strong>
                                            {{ $selectedProfile->ktp_number ?? '-' }}</li>
                                        <li class="list-group-item"><strong>No. HP:</strong>
                                            {{ $selectedProfile->phone_number ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Alamat:</strong>
                                            {{ $selectedProfile->address ?? '-' }}</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Riwayat Pendidikan -->
                            @if ($selectedProfile->education)
                                <hr>
                                <h6>Riwayat Pendidikan</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Jenjang:</strong>
                                        {{ $selectedProfile->education->majorities->grade->name ?? '-' }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Jurusan:</strong>
                                        {{ $selectedProfile->education->majorities->name ?? '-' }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Nama Sekolah:</strong>
                                        {{ $selectedProfile->education->school_name ?? '-' }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Tahun Lulus:</strong>
                                        {{ $selectedProfile->education->graduate_year ?? '-' }}
                                    </li>
                                </ul>
                            @else
                                <hr>
                                <p class="text-muted text-center">Tidak ada riwayat pendidikan.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Backdrop Modal -->
        @if ($showProfileModal)
            <div class="modal-backdrop fade show"></div>
        @endif

        <!-- Modal Dokumen -->
        @if ($showDocumentModal && !empty($selectedDocuments))
            <div class="modal fade show d-block overflow-auto" id="documentModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Dokumen Lamaran</h5>
                            <button type="button" class="close" wire:click="closeDocumentModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <!-- Daftar Dokumen -->
                            @if ($selectedDocuments['cv'])
                                <iframe
                                    src="https://docs.google.com/gview?url={{ urlencode(asset('storage/' . $selectedDocuments['cv'])) }}&embedded=true"
                                    style="width:100%; height:600px;" frameborder="0">
                                </iframe>
                            @else
                                <p><strong>Curriculum Vitae:</strong> Belum diupload</p>
                            @endif

                            @if ($selectedDocuments['transkrip'])
                                <div class="mb-3">
                                    <strong>Transkrip Nilai</strong>
                                    <iframe
                                        src=" https://docs.google.com/gview?url={{ urlencode(asset('storage/' . $selectedDocuments['transkrip'])) }}&embedded=true"
                                        style="width:100%; height:600px;" frameborder="0">
                                    </iframe>
                                </div>
                            @else
                                <p><strong>Transkrip Nilai:</strong> Belum diupload</p>
                            @endif

                            @if ($selectedDocuments['pakelaring'])
                                <div class="mb-3">
                                    <strong>Pakelaring / Surat Keterangan Kerja</strong>
                                    <iframe
                                        src=" https://docs.google.com/gview?url={{ urlencode(asset('storage/' . $selectedDocuments['pakelaring'])) }}&embedded=true"
                                        style="width:100%; height:600px;" frameborder="0">
                                    </iframe>
                                </div>
                            @else
                                <p><strong>Pakelaring:</strong> Belum diupload</p>
                            @endif

                            @if ($selectedDocuments['sertifikat'])
                                <div class="mb-3">
                                    <strong>Sertifikat Pendukung</strong>
                                    <iframe
                                        src=" https://docs.google.com/gview?url={{ urlencode(asset('storage/' . $selectedDocuments['sertifikat'])) }}&embedded=true"
                                        style="width:100%; height:600px;" frameborder="0">
                                    </iframe>
                                </div>
                            @else
                                <p><strong>Sertifikat:</strong> Belum diupload</p>
                            @endif

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="closeDocumentModal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Backdrop -->
        @if ($showDocumentModal)
            <div class="modal-backdrop fade show"></div>
        @endif

        <!-- Modal Hasil Ujian -->
        @if ($showExamModal && !empty($examResults))
            <div class="modal fade show d-block" id="examModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Hasil Ujian Pelamar</h5>
                            <button type="button" class="close" wire:click="closeExamModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if (!empty($examResults))
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Judul Ujian</th>
                                            <th>Tipe Ujian</th>
                                            <th>Skor Akhir</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($examResults as $result)
                                            <tr>
                                                <td>{{ $result['exam_title'] }}</td>
                                                <td>{{ $result['exam_type'] }}</td>
                                                <td>{{ $result['score'] }}</td>
                                                <td>{{ $result['started_at'] }}</td>
                                                <td>{{ $result['finished_at'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted text-center">Tidak ada hasil ujian.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="closeExamModal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backdrop -->
            <div class="modal-backdrop fade show"></div>
        @endif

        <div class="mt-3 d-flex justify-content-center">
            {{ $applications->links() }}
        </div>
    </div>
</div>
