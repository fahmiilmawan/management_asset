<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Laporan Pengaduan</h3>
            <p class="text-muted" id="real-time-clock">{{ Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Laporan Pengaduan</h5>
        </div>
        <div class="row m-3">
            <div class="col-md-3">
                <label for="filter_cari" class="form-label">Cari</label>
                <input type="text" class="form-control" wire:model.live="search" placeholder="Cari Pengaduan, Asset">
            </div>
            <div class="col-md-3">
                <label class="form-label">Dari</label>
                <input type="date" class="form-control" wire:model.live="start_date">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai</label>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
            <div class="col-md-3">
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
                        <th>Tanggal Pengaduan</th>
                        <th>Pengaduan</th>
                        <th>Diajukan Oleh</th>
                        <th>Nama Asset</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduans as $pengaduan)
                        <tr>
                            <td>{{ $pengaduan->tanggal_rusak }}</td>
                            <td>{{ $pengaduan->pengaduan }}</td>
                            <td>{{ $pengaduan->user->nama_lengkap }}</td>
                            <td>{{ $pengaduan->asset->barang->nama_barang }}</td>
                            <td>{{ $pengaduan->jumlah }}</td>
                            <td>
                                @php
                                $badge = match ($pengaduan->status) {
                                    'diajukan' => 'secondary' ,
                                     'diproses' => 'warning',
                                    'sudah diperbaiki' => 'success',
                                    'ditolak' => 'danger',
                                    }
                            @endphp
                                <span class="badge bg-{{ $badge }}">
                                    {{ ucfirst($pengaduan->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No results found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pengaduans->links() }}
        </div>
    </div>
</div>
