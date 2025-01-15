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
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary">
                            <i class="bi bi-box-seam text-white fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h6 class="card-title mb-0 text-uppercase text-secondary">Total Asset</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalAssets }}</h3>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col">
                            <h4 class="fw-bold mt-1 text-dark">{{ $assetsBaik }}</h4>
                            <span class="badge bg-success p-2 text-white">Baik</span>
                        </div>
                        <div class="col">
                            <h4 class="fw-bold mt-1 text-dark">{{ $totalPengaduan }}</h4>
                            <span class="badge bg-danger p-2 text-white">Rusak</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-center">
                    <a href="{{ route('index.asset') }}" class="btn btn-sm btn-primary px-4">Lihat Selengkapnya</a>
                </div>
            </div>

        </div>


        <!-- Data Pengadaan Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success">
                            <i class="bi bi-cart text-white fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h6 class="card-title mb-0 text-uppercase text-secondary">Total Pengadaan</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalPengadaan }}</h3>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengadaanDiajukan }}</h4>
                            <span class="badge bg-secondary p-2 text-white">Diajukan</span>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengadaanDiproses }}</h4>
                            <span class="badge bg-warning p-2 text-white">Diproses</span>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengadaanBarangTiba }}</h4>
                            <span class="badge bg-success p-2 text-white">Barang Tiba</span>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengadaanDitolak }}</h4>
                            <span class="badge bg-danger p-2 text-white">Ditolak</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-center">
                    <a href="{{ route('index.pengadaan') }}" class="btn btn-sm btn-success px-4">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
