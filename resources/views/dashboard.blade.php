@extends('layout.app')
@section('main-content')

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="mb-0 font-weight-bolder">Dashboard</h3>
            <p class="text-muted">{{ Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="row">
        <!-- Data Asset Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-header p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Data Asset</p>
                            <h4 class="mb-0">100</h4>
                        </div>
                        <div class="icon icon-md icon-shape bg-gradient-primary shadow-primary text-center border-radius-lg">
                            <i class="material-icons opacity-10">widgets</i>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-2">
                    <a href="#" class="btn btn-dark btn-sm">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>

        <!-- Example Card 2 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-header p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Transaksi Hari Ini</p>
                            <h4 class="mb-0">35</h4>
                        </div>
                        <div class="icon icon-md icon-shape bg-gradient-success shadow-success text-center border-radius-lg">
                            <i class="material-icons opacity-10">trending_up</i>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-2">
                    <a href="#" class="btn btn-success btn-sm">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>

        <!-- Example Card 3 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-header p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Pendapatan Bulan Ini</p>
                            <h4 class="mb-0">Rp 1,200,000</h4>
                        </div>
                        <div class="icon icon-md icon-shape bg-gradient-info shadow-info text-center border-radius-lg">
                            <i class="material-icons opacity-10">attach_money</i>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-2">
                    <a href="#" class="btn btn-info btn-sm">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>

        <!-- Example Card 4 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-header p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm mb-0 text-capitalize">Jumlah Pengguna</p>
                            <h4 class="mb-0">500</h4>
                        </div>
                        <div class="icon icon-md icon-shape bg-gradient-warning shadow-warning text-center border-radius-lg">
                            <i class="material-icons opacity-10">people</i>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-2">
                    <a href="#" class="btn btn-warning btn-sm">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
