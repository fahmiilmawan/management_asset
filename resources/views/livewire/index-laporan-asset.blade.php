<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Laporan Keseluruhan Aset</h3>
            <p class="text-muted" id="real-time-clock">{{ Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Laporan Keseluruhan Aset</h5>
        </div>
        <div class="row m-3">
            <div class="col-md-6">
                <label for="filter_unit" class="form-label">Cari</label>
                <input type="text" class="form-control" wire:model.live="search" placeholder="Cari Nama Asset, Unit, Ruangan">
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
                        <th>No Inventaris</th>
                        <th>Nama Aset</th>
                        <th>Untuk Unit</th>
                        <th>Jumlah</th>
                        <th>Berada di</th>
                        <th>Periode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assets as $asset)
                        <tr>
                            <td>{{ $asset->no_inventaris }}</td>
                            <td>{{ $asset->barang->nama_barang }}</td>
                            <td>{{ $asset->unit->nama_unit }}</td>
                            <td>{{ $asset->jumlah }}</td>
                            <td>{{ $asset->ruangan->nama_ruangan }}</td>
                            <td>{{ $asset->tahun }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No results found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Render pagination --}}
        <div class="card-footer">
            {{ $assets->links() }}
        </div>
    </div>
</div>
