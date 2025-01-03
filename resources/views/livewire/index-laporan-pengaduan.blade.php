<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Laporan Pengaduan</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
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
                <label for="asset" class="form-label">Filter Asset</label>
                <select name="asset" id="asset" class="form-control" wire:model.live="asset">
                    <option value=""> -- Pilih Asset -- </option>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset['asset_id'] }}"> {{ $asset['nama_asset'] }} </option>
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
                        <th>Pengaduan</th>
                        <th>Diajukan Oleh</th>
                        <th>Asset</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduans as $pengaduan)
                        <tr>
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
