@extends('layouts.home')
@section('title', 'Job Detail - Shabat Printing')
@section('home-content')
    <section id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center p-5">
                    <h3>Detail Lowongan</h3>
                    <h1 class="font-weight-bold">Operator Mesin Cetak.</h1>
                    <small class="mx-sm-3 mx-1"><ion-icon name="location"></ion-icon><span
                            class="align-text-bottom ml-1">Surakarta</span></small>
                    <small class="mx-sm-3 mx-1"><ion-icon name="time"></ion-icon><span
                            class="align-text-bottom ml-1">Full-Time</span></small>
                    <small class="mx-sm-3 mx-1"><ion-icon name="calendar"></ion-icon><span class="align-text-bottom ml-1">31
                            Februari 2033</span></small>
                </div>
            </div>

        </div>
    </section>

    <section id="job-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-8 pr-md-5 p-3">
                    <div class="card px-5 py-4">
                        <h3 class="font-weight-bold">Deskripsi Pekerjaan</h3>
                        <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                            occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <h3 class="font-weight-bold">Kualifikasi</h3>
                        <ul>
                            <li>Usia maksimal 30 tahun</li>
                            <li>Memiliki pengalaman minimal 2 tahun di bidang yang sama</li>
                            <li>Mampu bekerja dalam tim maupun individu</li>
                            <li>Memiliki kemampuan komunikasi yang baik</li>
                        </ul>
                        <a href="#" class="btn shadow-lg btn-md btn-primary mx-auto my-4 py-2"> Daftar akun untuk melamar </a>
                        

                    </div>
                </div>

                <div class="col-md-4 p-3">
                    <div class="card p-3 py-4">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset('app/img/Logo_square.png') }}" alt="Logo Square Shabat Printing"
                                    class="img-fluid mt-2 " style="max-width: 3rem;">
                            </div>
                            <div class="col-md-8 mt-3 mt-md-0 text-center text-md-left">
                                <h5 class="font-weight-bold">Shabat Printing</h5>
                                <small class="text-muted">Jl. Perintis kemerdekaan No.20 C-F,Surakarta</small>
                                <br>
                                <a href="#" class=""><small>Kunjungi situs web</small></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@stop
