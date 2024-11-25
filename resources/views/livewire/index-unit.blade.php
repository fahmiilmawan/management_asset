<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bolder mb-0">Data Unit</h3>
            <p class="text-muted">{{ Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" wire:click="openModal">
                <i class="fas fa-plus"></i> Tambah Unit
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

    <!-- Tabel Data Barang -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary ">
            <h5 class="mb-0 text-white">Daftar Unit</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Nama Unit</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $unit)
                            <tr>
                                <td>{{ $unit->nama_unit }}</td>
                                <td>{{ $unit->deskripsi }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning me-2" wire:click="edit({{ $unit->id }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger" wire:click="delete({{ $unit->id }})" wire:confirm="Are you sure you want to delete this post?">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada data unit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $units->links() }}
    </div>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">{{ $unit_id ? 'Edit Unit' : 'Tambah Unit' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="store">
                            <div class="mb-3">
                                <label for="nama_unit" class="form-label">Nama Unit</label>
                                <input type="text" class="form-control" id="nama_unit" wire:model="nama_unit" placeholder="Masukkan Nama Unit" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_unit" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control" id="deskripsi" wire:model="deskripsi" placeholder="Masukkan Deskripsi" required>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


