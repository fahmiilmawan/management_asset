<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bolder mb-0">Data Asset</h3>
            <p class="text-muted">{{ Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" wire:click="openModal">
                <i class="fas fa-plus"></i> Tambah Asset
            </button>
        </div>
    </div>

    <!-- Alert Pesan -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Data Asset -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary">
            <h5 class="mb-0 text-white">Daftar Asset</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>No Inventaris</th>
                            <th>Barang</th>
                            <th>Ruangan</th>
                            <th>Unit</th>
                            <th>Periode</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                            <tr>
                                <td>
                                    <a href="#" class="text-primary"
                                        wire:click.prevent="showDetail({{ $asset->id }})">
                                        {{ $asset->no_inventaris }}
                                    </a>
                                </td>
                                <td>{{ $asset->barang->nama_barang }}</td>
                                <td>{{ $asset->ruangan->nama_ruangan }}</td>
                                <td>{{ $asset->unit->nama_unit }}</td>
                                <td>{{ $asset->bulan }} {{ $asset->tahun }}</td>
                                <td>{{ $asset->jumlah }}</td>
                                <td>{{ $asset->satuan }}</td>
                                <td>
                                    <span class="badge bg-{{ $asset->status == 'baik' ? 'success' : 'danger' }}">
                                        {{ $asset->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning me-2" wire:click="edit({{ $asset->id }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger" wire:click="delete({{ $asset->id }})">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data asset.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $assets->links() }}
    </div>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">{{ $asset_id ? 'Edit Asset' : 'Tambah Asset' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="store">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Barang</label>
                                    <select class="form-select" wire:model="barang_id" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ruangan</label>
                                    <select class="form-select" wire:model="ruangan_id" required>
                                        <option value="">Pilih Ruangan</option>
                                        @foreach ($ruangans as $ruangan)
                                            <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit</label>
                                    <select class="form-select" wire:model="unit_id" required>
                                        <option value="">Pilih Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No Inventaris</label>
                                    <input type="text" class="form-control" wire:model="no_inventaris" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Bulan</label>
                                    <select class="form-select" wire:model="bulan" required>
                                        <option value="">Pilih Bulan</option>
                                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bln)
                                            <option value="{{ $bln }}">{{ $bln }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tahun</label>
                                    <input type="number" class="form-control" wire:model="tahun" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" wire:model="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="baik">Baik</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" wire:model="jumlah" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" class="form-control" wire:model="satuan" required>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeModal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Detail Asset -->
    @if ($isDetailModalOpen)
        <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Detail Asset</h5>
                        <button type="button" class="btn-close" wire:click="closeDetailModal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($selectedAsset)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No Inventaris</label>
                                    <input type="text" class="form-control"
                                        value="{{ $selectedAsset->no_inventaris }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Barang</label>
                                    <input type="text" class="form-control"
                                        value="{{ $selectedAsset->barang->nama_barang }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ruangan</label>
                                    <input type="text" class="form-control"
                                        value="{{ $selectedAsset->ruangan->nama_ruangan }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit</label>
                                    <input type="text" class="form-control"
                                        value="{{ $selectedAsset->unit->nama_unit }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Bulan</label>
                                    <input type="text" class="form-control" value="{{ $selectedAsset->bulan }}"
                                        readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun</label>
                                    <input type="text" class="form-control" value="{{ $selectedAsset->tahun }}"
                                        readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="text" class="form-control" value="{{ $selectedAsset->jumlah }}"
                                        readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" class="form-control" value="{{ $selectedAsset->satuan }}"
                                        readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <input type="text" class="form-control" value="{{ $selectedAsset->status }}"
                                        readonly>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
