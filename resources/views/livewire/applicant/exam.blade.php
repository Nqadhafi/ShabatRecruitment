<div class="container mt-4">
    {{-- @dd($examTitle) --}}
    @if($timeLeft > 0)
        <div class="text-center mb-3">
            <h5>Waktu tersisa: <span id="timer">{{ intdiv($timeLeft, 60) }}:{{ $timeLeft % 60 }}</span></h5>
        </div>
    @else
        <div class="text-center mb-3 text-danger">
            <h5>Waktu habis. Jawaban otomatis dikumpulkan...</h5>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Soal No. {{ $currentQuestionIndex + 1 }}
        </div>
        <div class="card-body">
            <!-- Isi Soal -->
            <p><strong>{{ $current['question_text'] }}</strong></p>

            <!-- Gambar Soal -->
            @if(!empty($current['image_path']))
                <img src="{{ asset('images/'.$current['image_path']) }}" class="img-fluid mb-3" />
            @endif

            <!-- Opsi Jawaban -->
            @php $options = json_decode($current['options'], true); @endphp

            @foreach($options as $key => $value)
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           wire:model="answers.{{ $currentQuestionIndex }}"
                           value="{{ $key }}">
                    <label class="form-check-label">{{ $key }}. {{ $value }}</label>
                </div>
            @endforeach

            <!-- Tombol Navigasi -->
            <div class="mt-4 d-flex justify-content-between">
                <button class="btn btn-secondary" wire:click="prevQuestion()" {{ $currentQuestionIndex == 0 ? 'disabled' : '' }}>
                    Sebelumnya
                </button>

                <button class="btn btn-success" wire:click="submit()" onclick="return confirm('Yakin selesai?')">
                    Selesai
                </button>

                <button class="btn btn-primary" wire:click="nextQuestion()"
                        {{ $currentQuestionIndex == count($questions) - 1 ? 'disabled' : '' }}>
                    Selanjutnya
                </button>
            </div>

            <!-- Menu Navigasi Soal -->
            <div class="mt-4 text-center">
                @for ($i = 0; $i < count($questions); $i++)
                    <button 
                        wire:click="goToQuestion({{ $i }})"
                        class="btn btn-sm 
                            @if (!isset($answers[$i]))
                                btn-outline-secondary
                            @else
                                btn-info
                            @endif">
                        {{ $i + 1 }}
                    </button>
                @endfor
            </div>
        </div>
    </div>
</div>

<!-- Timer JS -->
<script>
    let timeLeft = {{ $timeLeft }};
    const timerElement = document.getElementById("timer");

    setInterval(() => {
        if (timeLeft > 0) {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            timerElement.textContent = `${minutes}:${seconds < 10 ? '0'+seconds : seconds}`;
            timeLeft--;
        } else {
            @this.submit();
        }
    }, 1000);
</script>