<div>
<section id="hero" class="container-fluid bg-success">
        <div class="jumbotron container bg-success">
            <div class="row">
                <div class="col-md-6">
        <h1 class="display-5">Bergabunglah bersama kami !</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto reiciendis rem, sint autem adipisci esse? Impedit quidem saepe eum inventore.</p>
        <a class="btn btn-primary btn-md" href="#" role="button">Learn more</a>
                </div>
                <div class="d-none col-md-6 d-flex justify-content-center">
                <img src="{{asset('app/img/Jumbotron.png')}}" alt="" class="img-fluid" style="height: 20rem;">
                </div>
            </div>

        </div>
    </section>
<section id="jobs" class="mx-auto container mt-5 pt-5">
    <h2 class="display-5 text-center">Available Jobs</h2>

    <div class="text-center">
        <div class="btn-group-toggle" data-toggle="buttons">
            <!-- Button to show all jobs -->
            <label class="btn btn-secondary m-2" style="min-width: 5rem;" wire:click="showAllJobs">
                <input type="radio" name="options" id="option1" checked> All Jobs
            </label>
            
            <!-- Loop through the grades and display them -->
            @foreach ($grades as $grade)
            <label class="btn btn-secondary active m-2" style="min-width: 5rem;">
                <input type="radio" name="options" id="option1" wire:model="selectedGrade" value="{{ $grade->id }}"> 
                Min. {{ $grade->name }} 
                <span class="badge badge-light" wire:ignore>{{ $grade->jobs_count }}</span> <!-- Display the number of jobs per grade -->
            </label>
            @endforeach
        </div>
    </div>

    <div class="row gap-2 mt-4">
        @foreach ($jobs as $job)
        <div class="col-md-4 col-lg-3 col-sm-6 p-4 p-lg-4 p-md-3 p-sm-2">
            <div class="card">
                <div class="card-body shadow-lg">
                    <h6 class="card-title font-weight-bold mb-1 text-blue">{{ $job->name }}</h6>
                    <div class="card-text align-items-center d-flex">
                        <ion-icon name="bookmark" class="mr-1" wire:ignore></ion-icon>
                        <small>Shabat Printing</small>
                    </div>
                    <div class="card-text align-items-center d-flex mb-1">
                        <ion-icon name="pin" class="mr-1" wire:ignore></ion-icon>
                        <small class="text-muted">Laweyan, Surakarta</small>
                    </div>
                    <ul class="card-text px-3">
                        <li><small>{{ $job->contract }}</small></li>
                        <li><small>{{ $job->gender }}</small></li>
                        <li><small>Minimal pendidikan {{ $job->grade->name }}</small></li>
                    </ul>
                    <p class="text-muted text-center m-0">
                        <small>Batas Waktu: {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') }}</small>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
                @if ($noJobsMessage)
        <div class="text-center my-5 py-5">
            <h4>{{ $noJobsMessage }}</h4>
        </div>
    @endif
    <div class="text-center my-5">
        <a href="{{ route('register')}}" class="btn btn-primary">Siap bergabung dengan kami? Daftar di sini.</a>
    </div>
</section>


    <section id="about" class="container-fluid">
        <div class="jumbotron container bg-light">
            <div class="row">
                <div class="d-none col-md-6 d-flex justify-content-center">
                    <img src="{{asset('app/img/Jumbotron.png')}}" alt="" class="img-fluid" style="height: 10rem;">
                </div>
                <div class="col-md-6">
                    <h1 class="display-5">Tentang Kami</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto reiciendis rem, sint autem adipisci esse? Impedit quidem saepe eum inventore.</p>
                    <button class="btn btn-primary btn-md">Selengkapnya</button>
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

