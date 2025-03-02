@extends('layout.app')
@section('main-content')

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="mb-0 font-weight-bolder">Dashboard - {{ Auth::user()->name }}</h3>
            <p class="text-muted">{{ Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="row">
        @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')

        <!-- Data Asset Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="card-icon-container">
                            <div class="circle-bg">
                                <i class="bi bi-box-seam icon-style"></i>
                            </div>
                        </div>
                        <div class="ps-3">
                            <h6 class="card-title mb-0 text-uppercase text-secondary">Total Asset</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalKeseluruhan }}</h3>
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

        @endif
        <!-- Data Pengadaan Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="card-icon-container">
                            <div class="circle-bg">
                                <i class="bi bi-cart icon-style"></i>
                            </div>
                        </div>
                        <div class="ps-3">
                            <h6 class="card-title mb-0 text-uppercase text-secondary">Total Pengadaan</h6>
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalKeseluruhanPengadaan }}</h3>
                            @else
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalPengadaan }}</h3>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h4 class="fw-bold mt-1 text-dark">{{ $totalPengadaanAdmin }}</h4>
                            @else
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengadaanDiajukan }}</h4>
                            @endif
                            <span class="badge bg-secondary p-2 text-white">Diajukan</span>
                        </div>
                        <div class="col-6">
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h4 class="fw-bold mt-1 text-dark">{{ $totalPengadaanAdminDiproses }}</h4>
                            @else
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengadaanDiproses }}</h4>
                            @endif
                            <span class="badge bg-warning p-2 text-white">Diproses</span>
                        </div>
                        <div class="col-6">
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h4 class="fw-bold mt-1 text-dark">{{ $totalPengadaanAdminBarangTiba }}</h4>
                            @else
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengadaanBarangTiba }}</h4>
                            @endif
                            <span class="badge bg-success p-2 text-white">Barang Tiba</span>
                        </div>
                        <div class="col-6">
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h4 class="fw-bold mt-1 text-dark">{{ $totalPengadaanAdminDitolak }}</h4>
                            @else
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengadaanDitolak }}</h4>
                            @endif
                            <span class="badge bg-danger p-2 text-white">Ditolak</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-center">
                    <a href="{{ route('index.pengadaan') }}" class="btn btn-sm btn-primary px-4">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>

        <!-- Data Pengaduan Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger">
                            <i class="bi bi-exclamation-circle text-white fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h6 class="card-title mb-0 text-uppercase text-secondary">Total Pengaduan</h6>
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalKeseluruhanPengaduan }}</h3>
                            @else
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalPengaduan }}</h3>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h4 class="fw-bold mt-1 text-dark">{{ $totalPengaduanAdmin }}</h4>
                            @else
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengaduanDiajukan }}</h4>
                            @endif
                            <span class="badge bg-secondary p-2 text-white">Diajukan</span>
                        </div>
                        <div class="col-6">
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h4 class="fw-bold mt-1 text-dark">{{ $totalPengaduanAdminDiproses }}</h4>

                            @else
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengaduanDiproses }}</h4>
                            @endif
                            <span class="badge bg-warning p-2 text-white">Diproses</span>
                        </div>
                        <div class="col-6 mt-2">
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h4 class="fw-bold mt-1 text-dark">{{ $totalPengaduanAdminSelesai }}</h4>
                            @else
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengaduanSelesai }}</h4>
                            @endif
                            <span class="badge bg-success p-2 text-white">Sudah Diperbaiki</span>
                        </div>
                        <div class="col-6 mt-2">
                            @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'administrator')
                            <h4 class="fw-bold mt-1 text-dark">{{ $totalPengaduanAdminDitolak }}</h4>
                            @else
                            <h4 class="fw-bold mt-1 text-dark">{{ $pengaduanDitolak }}</h4>
                            @endif
                            <span class="badge bg-danger p-2 text-white">Ditolak</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-center">
                    <a href="{{ route('index.pengaduan') }}" class="btn btn-sm btn-danger px-4">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection
