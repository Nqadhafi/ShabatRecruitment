<div>
    @if($this->titles->isNotEmpty() && $this->currentTitleIndex < count($this->titles))
        <div class="container mt-4">
            <!-- Judul Ujian -->
            <h5 class="text-center mb-3" wire:ignore>{{ $examTitle->title }}</h5>

            <!-- Timer -->
            @if($timeLeft > 0)
                <div class="text-center mb-3" wire:ignore>
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

                    <div class="btn-group-vertical w-100" data-toggle="buttons">
                        @foreach($options as $key => $value)
                            <label class="btn btn-outline-primary text-left mb-2 {{ (isset($answers[$currentQuestionIndex]) && $answers[$currentQuestionIndex] == $key) ? 'active' : '' }}">
                                <input type="radio"
                                       wire:model="answers.{{ $currentQuestionIndex }}"
                                       value="{{ $key }}"
                                       autocomplete="off"> 
                                <strong>{{ $key }}.</strong> {{ $value }}
                            </label>
                        @endforeach
                    </div>

                    <!-- Tombol Navigasi -->
                    <div class="mt-4 d-flex justify-content-between">
                        <button class="btn btn-secondary" wire:click="prevQuestion()" 
                                {{ $currentQuestionIndex == 0 ? 'disabled' : '' }}>
                            Sebelumnya
                        </button>

                        <button class="btn btn-success" wire:click="submit()" onclick="return confirm('Yakin selesai?')">
                            {{ $currentTitleIndex + 1 == count($this->titles) ? 'Selesaikan Semua' : 'Lanjutkan ke Ujian Berikutnya' }}
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

        <!-- Script Timer -->
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
    @else
        <div class="container mt-5 text-center">
            <h4>Semua ujian telah diselesaikan.</h4>
            <p>Terima kasih telah menyelesaikan rangkaian ujian kami</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
    @endif
</div>