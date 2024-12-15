@extends('layout.app')
@section('main-content')
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Informasi Asset</h6>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong>Barang:</strong> <span>{{ $getInventaris->barang->nama_barang }}</span>
            </li>
            <li class="list-group-item">
                <strong>No Inventaris:</strong> <span>{{ $getInventaris->no_inventaris }}</span>
            </li>
            <li class="list-group-item">
                <strong>Bulan:</strong> <span>{{ $getInventaris->bulan }}</span>
            </li>
            <li class="list-group-item">
                <strong>Tahun:</strong> <span>{{ $getInventaris->tahun }}</span>
            </li>
            <li class="list-group-item">
                <strong>Jumlah:</strong> <span>{{ $getInventaris->jumlah }}</span>
            </li>
            <li class="list-group-item">
                <strong>Satuan:</strong> <span>{{ $getInventaris->satuan }}</span>
            </li>
            <li class="list-group-item">
                <strong>Status:</strong> <span class="badge bg-{{ $getInventaris->status == 'baik' ? 'success' : 'danger' }}">{{ ucfirst($getInventaris->status) }}</span>
            </li>
        </ul>
    </div>
</div>

@endsection
