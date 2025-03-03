<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Laporan Pengadaan</h3>
            <p class="text-muted" id="real-time-clock">{{ Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Laporan Keseluruhan Pengadaan</h5>
        </div>
        <div class="row m-3">
            <div class="col-md-2">
                <label for="filter_unit" class="form-label">Cari</label>
                <input type="text" class="form-control" wire:model.live="search" placeholder="Cari Nama Barang, Ruangan">
            </div>
            <div class="col-md-3">
                <label class="form-label">Dari</label>
                <input type="date" class="form-control" wire:model.live="start_date">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai</label>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
            <div class="col-md-4">
                <label for="filter_unit" class="form-label">Export</label>
                <div>
                    <button wire:click="printPDF" class="btn btn-primary"> Print PDF</button>
                    <button wire:click="exportExcel" class="btn btn-success">Export Excel</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal Pengadaan</th>
                        <th>Nama Barang</th>
                        <th>Diajukan Oleh</th>
                        <th>Untuk Ruangan</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengadaans as $pengadaan)
                        <tr>
                            <td>{{ $pengadaan->tanggal_pengadaan }}</td>
                            <td>{{ $pengadaan->nama_barang_pengadaan }}</td>
                            <td>{{ $pengadaan->user->nama_lengkap }}</td>
                            <td>{{ $pengadaan->ruangan->nama_ruangan }}</td>
                            <td>{{ $pengadaan->jumlah_pengadaan }}</td>
                            <td>Rp.{{ number_format($pengadaan->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp.{{ number_format($pengadaan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No results found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pengadaans->links() }}
        </div>
    </div>
</div>
