<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Laporan Keseluruhan Asset</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>
    </div>
    {{-- End of Header --}}


    <!-- Tabel -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Laporan Keseluruhan Asset</h5>
        </div>
        <div class="row m-3">
            <div class="col-md-6">
                <label for="filter_unit" class="form-label">Cari</label>
                <input type="text" class="form-control" wire:model.live = "search" placeholder="Cari Nama Barang, Unit, Ruangan">
            </div>
            <div class="col-md-6">
                <label for="filter_unit" class="form-label">Filter Periode</label>
                <select name="periode" id="periode" class="form-control" wire:model.live="periode">
                    <option value=""> -- Pilih Periode -- </option>
                    @foreach ( $periodes as $periode)
                    <option value="{{ $periode }}"> {{ $periode }} </option>

                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No Inventaris</th>
                        <th>Nama Asset</th>
                        <th>Untuk Unit</th>
                        <th>Jumlah</th>
                        <th>Berada di</th>
                        <th>Periode</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data laporan asset from render component --}}
                    @forelse ( $assets as $asset )
                    <tr>

                        <td>{{ $asset->no_inventaris }}</td>
                        <td>{{ $asset->barang->nama_barang }}</td>
                        <td>{{ $asset->unit->nama_unit }}</td>
                        <td>{{ $asset->jumlah }}</td>
                        <td>{{ $asset->ruangan->nama_ruangan }}</td>
                        <td>{{ $asset->tahun }}</td>
                        @empty
                        <td colspan="3" class="text-center">Tidak ada data barang.</td>
                        @endforelse
                    </tr>
                    {{-- End Looping data from render component --}}
                </tbody>
            </table>
        </div>

        {{-- Render pagination --}}
        <div class="card-footer">
            {{ $assets->links() }}
        </div>
    </div>
    {{-- End Render pagination --}}

</div>




