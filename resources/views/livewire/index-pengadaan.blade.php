<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Pengadaan</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" wire:click="openModal">
                <i class="fas fa-plus"></i> Tambah Pengadaan
            </button>
        </div>
    </div>

    <!-- Alert -->
    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Tabel -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Pengadaan</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Ruangan</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengadaans as $pengadaan)
                    <tr>
                        <td>{{ $pengadaan->nama_barang_pengadaan }}</td>
                        <td>{{ $pengadaan->ruangan->nama_ruangan }}</td>
                        <td>{{ $pengadaan->jumlah_pengadaan }}</td>
                        <td>{{ number_format($pengadaan->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ number_format($pengadaan->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-gradient-{{
                                $pengadaan->status_pengadaan === 'diproses' ? 'warning' :
                                ($pengadaan->status_pengadaan === 'barang tiba' ? 'success' : 'info') }}">
                                {{ ucfirst($pengadaan->status_pengadaan) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalForm" wire:click="edit({{ $pengadaan->id }})">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete" wire:click="confirmDelete({{ $pengadaan->id }})">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $pengadaans->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    <div wire:ignore.self class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $pengadaan_id ? 'update' : 'store' }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFormLabel">
                            {{ $pengadaan_id ? 'Edit Pengadaan' : 'Tambah Pengadaan' }}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <!-- Input Fields -->

                        <div class="mb-3">
                            <label for="nama_barang_pengadaan" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control border p-2" id="nama_barang_pengadaan" wire:model="nama_barang_pengadaan">
                            @error('nama_barang_pengadaan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ruangan_id" class="form-label">Untuk Ruangan</label>
                            <select class="form-select p-2" id="ruangan_id" wire:model="ruangan_id">
                                <option value=""> Pilih Ruangan </option>
                                @foreach ($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                                @endforeach
                            </select>
                            @error('ruangan_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="satuan_pengadaan" class="form-label">Satuan</label>
                            <input type="text" class="form-control border p-2" id="satuan_pengadaan" wire:model="satuan_pengadaan">
                            @error('satuan_pengadaan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_pengadaan" class="form-label">Jumlah</label>
                            <input type="number" class="form-control border p-2" id="jumlah_pengadaan" wire:model="jumlah_pengadaan">
                            @error('jumlah_pengadaan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga_satuan" class="form-label">Harga Satuan</label>
                            <input type="number" class="form-control border p-2" id="harga_satuan" wire:model="harga_satuan" wire:keyup="calculateTotal">
                            @error('harga_satuan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input type="number" class="form-control border p-2" id="total_harga" wire:model="total_harga" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="tahun_pengadaan" class="form-label">Tahun Pengadaan</label>
                            <input type="number" class="form-control border p-2" id="tahun_pengadaan" wire:model="tahun_pengadaan">
                            @error('tahun_pengadaan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                            <input type="date" class="form-control border p-2" id="tanggal_pengadaan" wire:model="tanggal_pengadaan">
                            @error('tanggal_pengadaan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_pengadaan" class="form-label">Status Pengadaan</label>
                            <select class="form-select" id="status_pengadaan" wire:model="status_pengadaan">
                                <option value=""> Pilih Status </option>
                                <option value="diterima">Diterima</option>
                                <option value="diproses">Diproses</option>
                                <option value="barang tiba">Barang Tiba</option>
                            </select>
                            @error('status_pengadaan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">{{ $pengadaan_id ? 'Simpan Perubahan' : 'Tambah' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Delete -->
    <div wire:ignore.self class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus</h5>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="delete" data-bs-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
