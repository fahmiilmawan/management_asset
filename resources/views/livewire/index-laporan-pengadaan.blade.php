<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Laporan Pengadaan</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Laporan Keseluruhan Pengadaan</h5>
        </div>
        <div class="row m-3">
            <div class="col-md-3">
                <label for="filter_unit" class="form-label">Cari</label>
                <input type="text" class="form-control" wire:model.live="search" placeholder="Cari Nama Barang, Ruangan">
            </div>
            <div class="col-md-3">
                <label for="ruangan" class="form-label">Filter Ruangan</label>
                <select name="ruangan" id="ruangan" class="form-control" wire:model.live="ruangan">
                    <option value=""> -- Pilih Ruangan -- </option>
                    @foreach ($ruangans as $ruangan)
                        <option value="{{ $ruangan['ruangan_id'] }}"> {{ $ruangan['nama_ruangan'] }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="user" class="form-label">Diajukan Oleh</label>
                <select name="user" id="user" class="form-control" wire:model.live="user">
                    <option value=""> -- Pilih Yang Mengajukan -- </option>
                    @foreach ($users as $u)
                        <option value="{{ $u['user_id'] }}"> {{ $u['nama_lengkap'] }} </option>
                    @endforeach
                </select>
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
                        <th>Nama Barang</th>
                        <th>Diajukan Oleh</th>
                        <th>Untuk Ruangan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengadaans as $pengadaan)
                        <tr>
                            <td>{{ $pengadaan->nama_barang_pengadaan }}</td>
                            <td>{{ $pengadaan->user->nama_lengkap }}</td>
                            <td>{{ $pengadaan->ruangan->nama_ruangan }}</td>
                            <td>{{ $pengadaan->jumlah_pengadaan }}</td>
                            <td>{{ $pengadaan->satuan_pengadaan }}</td>
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
