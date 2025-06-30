@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1>Halo Bapak/Ibu HRD</h1>
    <p>Selamat datang di portal manajemen recruitment Shabat Printing.</p>
@stop

@section('content')
    <div class="container-fluid ">
        <div class="row justify-content-center  align-self-center">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>

                        <p>Lamaran Belum Di Proses</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Lowongan Kerja Aktif</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>
    </div>
@stop
