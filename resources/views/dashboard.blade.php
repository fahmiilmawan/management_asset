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
                            <p class="text-sm mb-0 text-capitalize">Data Barang</p>
                            <h4 class="mb-0">{{ $dataBarang }}</h4>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-2">
                    <a href="{{ route('index.barang') }}" class="btn btn-dark btn-sm">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
