<div class="form-group">
    <label for="question_text">Isi Soal</label>
    <textarea name="question_text" id="question_text" rows="3"
              class="form-control @error('question_text') is-invalid @enderror"
              required>{{ old('question_text', $examQuestion->question_text ?? '') }}</textarea>
    @error('question_text')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="image">Gambar Soal (Opsional)</label>
    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
    @if(isset($examQuestion) && $examQuestion->image_path)
        <div class="mt-2">
            <img src="{{ asset('images/' . $examQuestion->image_path) }}" alt="Soal Gambar" class="img-thumbnail" style="max-height: 200px;">
        </div>
    @endif
    @error('image')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<!-- Opsi Jawaban Dinamis -->
<div id="options-container">
    <div class="form-group">
        <label>Opsi Jawaban</label>

        @php
            // Ambil data dari session atau model
            $options = old('options', json_decode($examQuestion->options ?? '', true) ?: ['A' => '', 'B' => '', 'C' => '', 'D' => '']);
            $points = old('points', json_decode($examQuestion->points ?? '', true) ?: []);
            $correctAnswer = old('correct_answer', $examQuestion->correct_answer ?? '');
        @endphp

        <!-- Loop Opsi Awal -->
        @foreach(['A', 'B', 'C', 'D'] as $key)
            <div class="row mb-2 option-row">
                <div class="col-md-1 d-flex align-items-center">
                    <strong>{{ $key }}</strong>
                </div>
                <div class="col-md-5">
                    <input type="text" name="options[{{ $key }}]" class="form-control" value="{{ $options[$key] ?? '' }}" required>
                </div>
                @if($examTitle->exam_type === 'benar_salah')
                    <div class="col-md-5">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="correct_answer" value="{{ $key }}"
                                {{ $correctAnswer == $key ? 'checked' : '' }}>
                            <label class="form-check-label">Jawaban Benar</label>
                        </div>
                    </div>
                @elseif($examTitle->exam_type === 'poin')
                    <div class="col-md-3">
                        <input type="number" name="points[{{ $key }}]" class="form-control mt-2" min="0"
                               value="{{ $points[$key] ?? 0 }}" placeholder="Poin">
                    </div>
                @endif
            </div>
        @endforeach

        <!-- Opsi Tambahan -->
        @if(is_array($options))
            @foreach(array_slice(array_keys($options), 4) as $key)
                <div class="row mb-2 option-row">
                    <div class="col-md-1 d-flex align-items-center">
                        <strong>{{ $key }}</strong>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="options[{{ $key }}]" class="form-control" value="{{ $options[$key] }}" required>
                    </div>
                    @if($examTitle->exam_type === 'benar_salah')
                        <div class="col-md-5">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="correct_answer" value="{{ $key }}"
                                    {{ $correctAnswer == $key ? 'checked' : '' }}>
                                <label class="form-check-label">Jawaban Benar</label>
                            </div>
                        </div>
                    @elseif($examTitle->exam_type === 'poin')
                        <div class="col-md-3">
                            <input type="number" name="points[{{ $key }}]" class="form-control mt-2" min="0"
                                   value="{{ $points[$key] ?? 0 }}" placeholder="Poin">
                        </div>
                    @endif
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-option"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="form-group mt-3">
        <button type="button" id="add-option-btn" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Jawaban
        </button>
    </div>
</div>



<!-- Script JS untuk Tambah Jawaban -->
<script>
    // Baca semua key dari opsi awal (A-D atau E-F jika sudah ditambah)
    let existingKeys = [
        @foreach(array_keys($options) as $key)
            "{{ $key }}",
        @endforeach
    ];

    // Cari huruf terakhir untuk lanjut menambahkan
    let currentKey = existingKeys.length > 0
        ? String.fromCharCode(existingKeys.slice(-1)[0].charCodeAt(0) + 1)
        : 'E';

    document.getElementById('add-option-btn').addEventListener('click', function () {
        const container = document.getElementById('options-container');

        const div = document.createElement('div');
        div.className = 'row mb-2 option-row';

        @if($examTitle->exam_type === 'benar_salah')
            div.innerHTML = `
                <div class="col-md-1 d-flex align-items-center">
                    <strong>${currentKey}</strong>
                </div>
                <div class="col-md-5">
                    <input type="text" name="options[${currentKey}]" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="correct_answer" value="${currentKey}">
                        <label class="form-check-label">Jawaban Benar</label>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-option"><i class="fas fa-trash"></i></button>
                </div>
            `;
        @elseif($examTitle->exam_type === 'poin')
            div.innerHTML = `
                <div class="col-md-1 d-flex align-items-center">
                    <strong>${currentKey}</strong>
                </div>
                <div class="col-md-5">
                    <input type="text" name="options[${currentKey}]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="points[${currentKey}]" class="form-control mt-2" min="0" value="0" placeholder="Poin">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-option"><i class="fas fa-trash"></i></button>
                </div>
            `;
        @else
            div.innerHTML = `
                <div class="col-md-1 d-flex align-items-center">
                    <strong>${currentKey}</strong>
                </div>
                <div class="col-md-5">
                    <input type="text" name="options[${currentKey}]" class="form-control" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-option"><i class="fas fa-trash"></i></button>
                </div>
            `;
        @endif

        container.appendChild(div);
        existingKeys.push(currentKey); // Simpan key baru
        currentKey = String.fromCharCode(currentKey.charCodeAt(0) + 1); // Lanjut ke huruf berikutnya
    });

    // Hapus jawaban dinamis
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-option')) {
            const row = e.target.closest('.option-row');
            const keyToRemove = row.querySelector('strong').textContent.trim();
            existingKeys = existingKeys.filter(key => key !== keyToRemove);
            row.remove();
        }
    });
</script>