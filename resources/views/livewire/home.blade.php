<div>
<!-- Carousel -->
<div id="heroCarousel" class="carousel slide vh-100" data-ride="carousel">
  <div class="carousel-inner h-100">

    <!-- Slide 1 -->
    <div class="carousel-item active h-100">
      <div class="d-flex align-items-center justify-content-center h-100 text-white text-center" style="background: url('{{asset('app/img/Jumbotron1.webp')}}') center center / cover no-repeat; position: relative;">
        <div style="position: absolute; top: 0; left: 0; height: 100%; width: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
        <div class="container position-relative">
          <h1 class=" font-weight-bold">Bergabunglah bersama kami!</h1>
          <p class="lead">Kami mencari talenta berbakat untuk bergabung dalam dunia percetakan digital yang inovatif dan kreatif.</p>
          <a href="#jobs" class="btn btn-lg mt-3 btn-primary text-white">Cek lowongan terbaru</a>
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item h-100">
      <div class="d-flex align-items-center justify-content-center h-100 text-white text-center" style="background: url('{{asset('app/img/Jumbotron2.webp')}}') center center / cover no-repeat; position: relative;">
        <div style="position: absolute; top: 0; left: 0; height: 100%; width: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
        <div class="container position-relative">
          <h1 class=" font-weight-bold">Jelajahi dunia digital printing!</h1>
          <p class="lead">Punya passion di desain atau dunia percetakan? Ubah kreativitasmu jadi sebuah perjalanan karier yang seru</p>
          <a href="#jobs" class="btn btn-light btn-lg mt-3">Cek lowongan terbaru</a>
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item h-100">
      <div class="d-flex align-items-center justify-content-center h-100 text-white text-center" style="background: url('{{asset('app/img/Jumbotron3.webp')}}') center center / cover no-repeat; position: relative;">
        <div style="position: absolute; top: 0; left: 0; height: 100%; width: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
        <div class="container position-relative">
          <h1 class=" font-weight-bold">Mulai karirmu di sini!</h1>
          <p class="lead">Mulai perjalananmu sekarang di perusahaan percetakan digital yang terus berkembang</p>
          <a href="{{ route('register')}}" class="btn btn-outline-light btn-lg mt-3">Gabung Sekarang</a>
        </div>
      </div>
    </div>

  </div>

  <!-- Controls -->
  <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Sebelumnya</span>
  </a>
  <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Selanjutnya</span>
  </a>
</div>

<section id="jobs" class="mx-auto container mt-5 pt-5">
    <h2 class="display-5 text-center">Lowongan tersedia</h2>

<div class="text-center">
    <div class="btn-group-toggle" data-toggle="buttons">
        <!-- Button to show all jobs -->
        <label class="btn btn-primary m-2 {{ is_null($selectedGrade) ? 'active' : '' }}" style="min-width: 5rem;">
            <input type="radio" name="options" wire:click="showAllJobs" wire:model="selectedGrade" value=""> All Jobs
        </label>

        <!-- Loop through the grades and display them -->
        @foreach ($grades as $grade)
            <label class="btn btn-primary m-2 {{ $selectedGrade == $grade->id ? 'active' : '' }}" style="min-width: 5rem;">
                <input type="radio" name="options" wire:model="selectedGrade" value="{{ $grade->id }}"> 
                Min. {{ $grade->name }} 
                <span class="badge badge-light" wire:ignore>{{ $grade->jobs_count }}</span>
            </label>
        @endforeach
    </div>
</div>

<div class="row gap-2 mt-4">
    @foreach ($jobs as $job)
    <div class="col-md-4 col-lg-3 col-sm-6 p-4 p-lg-4 p-md-3 p-sm-2">
        <a class="card text-reset text-decoration-none" target="_blank" href="{{ route('job.detail', $job->slug ?? '') }}">
            <div class="card-body shadow-lg">
                <h6 class="card-title font-weight-bold mb-1 text-magenta">{{ $job->name }}</h6>
                <div class="card-text align-items-center d-flex">
                    <ion-icon name="bookmark" class="mr-1" wire:ignore></ion-icon>
                    <small>Shabat Printing</small>
                </div>
                <div class="card-text align-items-center d-flex mb-1">
                    <ion-icon name="pin" class="mr-1" wire:ignore></ion-icon>
                    <small class="text-muted">Laweyan, Surakarta</small>
                </div>
                <ul class="card-text px-3">
                    <li><small>{{ $job->gender }}</small></li>
                    <li><small>{{ $job->contract }}</small></li>
                    <li><small>Minimal pendidikan {{ $job->grade->name }}</small></li>
                </ul>
                <p class="text-muted text-center m-0">
                    <small>Batas Waktu: {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') }}</small>
                </p>
            </div>
        </a>
    </div>
    @endforeach
</div>

@if ($noJobsMessage)
    <div class="text-center my-5 py-5">
        <h4>{{ $noJobsMessage }}</h4>
    </div>
@endif

<div class="text-center mb-5">
    <a href="{{ route('register') }}" class="btn btn-primary shadow-lg">Siap bergabung dengan kami? Daftar di sini.</a>
</div>
</section>

<section id="about" class="container-fluid py-5">
    <div class="jumbotron container bg-light p-0">
        <div class="row">
            <div class="d-none col-md-6 d-flex">
                <img src="{{asset('app/img/About-us.webp')}}" alt="" class="img-fluid">
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center p-5">
                <h1 class="display-5">Tentang Kami</h1>
                <h5 class="text-blue font-weight-bold p-0 m-0">Shabat Printing</h5>
                <p> adalah solusi percetakan digital dan offset terdepan di Kota Solo.
Sebagai salah satu anak perusahaan PT. SHA Solo, kami berkomitmen menghadirkan layanan cetak berkualitas tinggi, cepat, dan terpercaya.
Didukung teknologi modern dan tim profesional, Shabat Printing menjadi pilihan utama untuk berbagai kebutuhan percetakan , mulai dari skala retail hingga bisnis.</p>
                <a class="btn btn-primary btn-md w-50" href="https://shabatprinting.com" target="_blank">Selengkapnya</a>
            </div>
        </div>
</section>

<section id="contact" class="mx-auto mt-5 container-fluid">
    <div class="container">
    <h2 class="text-center display-5"> Hubungi Kami </h2>
    <div class="row mt-3">
        <div class="col-lg-6 mt-3 p-4">
            <div class="card rounded shadow-md bg-secondary">
                <div class="card-body p-5">
                    <ion-icon name="location" size="large"></ion-icon>
                    <h4 class="mt-1">Alamat</h4>
                    <p class="card-text">Jl. Perintis Kemerdekaan No. 20 C-D, Kel. Sondakan, Kec. Laweyan, Kota Surakarta, Jawa Tengah</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-3 p-4">
            <div class="card rounded shadow-md bg-secondary">
                <div class="card-body p-5">
                    <ion-icon name="mail" size="large"></ion-icon>
                    <h4 class="mt-1">E-mail</h4>
                    <p class="card-text">hrd.shabatwarna@gmail.com
                        <br>
                        <br>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-3 p-4">
            <div class="card rounded shadow-md bg-secondary">
                <div class="card-body p-5">
                    <ion-icon name="call" size="large"></ion-icon>
                    <h4 class="mt-1">Telepon</h4>
                    <h6><i>(Text / Whatsapp Only)</i></h6>
                    <p class="card-text">+62813 8883 9991</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-3 p-4">
            <div class="card rounded shadow-md bg-secondary">
                <div class="card-body p-5">
                    <ion-icon name="time" size="large"></ion-icon>
                    <h4 class="mt-1">Jam Operasional</h4>
                    <div class="row">
                        <div class="col-6">
                            <p class="card-text p-0 m-0">Senin s/d Jum'at</p>
                            <p class="card-text p-0 m-0">08.00 - 16.00</p>
                        </div>
                        <div class="col-6">
                            <p class="card-text p-0 m-0">Sabtu </p>
                            <p class="card-text p-0 m-0">10.00 - 15.30</p>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
</div>

