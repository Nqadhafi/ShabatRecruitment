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

<div class="form-group">
    <label>Opsi Jawaban</label>
    <div class="row">
        <div class="col-md-6">
            <input type="text" name="option_a" class="form-control mb-2 @error('option_a') is-invalid @enderror"
                   placeholder="Opsi A" value="{{ old('option_a', $examQuestion->option_a ?? '') }}" required>
            <input type="text" name="option_b" class="form-control mb-2 @error('option_b') is-invalid @enderror"
                   placeholder="Opsi B" value="{{ old('option_b', $examQuestion->option_b ?? '') }}" required>
        </div>
        <div class="col-md-6">
            <input type="text" name="option_c" class="form-control mb-2 @error('option_c') is-invalid @enderror"
                   placeholder="Opsi C" value="{{ old('option_c', $examQuestion->option_c ?? '') }}" required>
            <input type="text" name="option_d" class="form-control mb-2 @error('option_d') is-invalid @enderror"
                   placeholder="Opsi D" value="{{ old('option_d', $examQuestion->option_d ?? '') }}" required>
        </div>
    </div>
</div>

@if($examTitle->exam_type === 'benar_salah')
    <div class="form-group">
        <label for="correct_answer">Jawaban Benar</label>
        <select name="correct_answer" id="correct_answer" class="form-control @error('correct_answer') is-invalid @enderror" required>
            <option value="">-- Pilih Jawaban --</option>
            <option value="A" {{ old('correct_answer', $examQuestion->correct_answer ?? '') == 'A' ? 'selected' : '' }}>A</option>
            <option value="B" {{ old('correct_answer', $examQuestion->correct_answer ?? '') == 'B' ? 'selected' : '' }}>B</option>
            <option value="C" {{ old('correct_answer', $examQuestion->correct_answer ?? '') == 'C' ? 'selected' : '' }}>C</option>
            <option value="D" {{ old('correct_answer', $examQuestion->correct_answer ?? '') == 'D' ? 'selected' : '' }}>D</option>
        </select>
        @error('correct_answer')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
@else
    <div class="form-group">
        <label>Poin Jawaban</label>
        <div class="row">
            <div class="col-md-3">
                <input type="number" name="point_a" class="form-control mb-2 @error('point_a') is-invalid @enderror"
                       placeholder="Poin A" min="0"
                       value="{{ old('point_a', $examQuestion->point_a ?? 0) }}" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="point_b" class="form-control mb-2 @error('point_b') is-invalid @enderror"
                       placeholder="Poin B" min="0"
                       value="{{ old('point_b', $examQuestion->point_b ?? 0) }}" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="point_c" class="form-control mb-2 @error('point_c') is-invalid @enderror"
                       placeholder="Poin C" min="0"
                       value="{{ old('point_c', $examQuestion->point_c ?? 0) }}" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="point_d" class="form-control mb-2 @error('point_d') is-invalid @enderror"
                       placeholder="Poin D" min="0"
                       value="{{ old('point_d', $examQuestion->point_d ?? 0) }}" required>
            </div>
        </div>
    </div>
@endif