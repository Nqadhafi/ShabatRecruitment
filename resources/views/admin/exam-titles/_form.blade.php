<div class="form-group">
    <label for="title">Judul Ujian</label>
    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $examTitle->title ?? '') }}" required>
    @error('title')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="exam_type">Tipe Soal</label>
    <select name="exam_type" id="exam_type" class="form-control @error('exam_type') is-invalid @enderror" required>
        <option value="">-- Pilih Tipe --</option>
        <option value="poin" {{ old('exam_type', $examTitle->exam_type ?? '') == 'poin' ? 'selected' : '' }}>Poin</option>
        <option value="benar_salah" {{ old('exam_type', $examTitle->exam_type ?? '') == 'benar_salah' ? 'selected' : '' }}>Benar/Salah</option>
    </select>
    @error('exam_type')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <input type="hidden" name="is_active" value="0">
    <div class="custom-control custom-switch">
        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active"
               value="1"
               {{ old('is_active', $examTitle->is_active ?? false) ? 'checked' : '' }}>
        <label class="custom-control-label" for="is_active">Aktif?</label>
    </div>
</div>