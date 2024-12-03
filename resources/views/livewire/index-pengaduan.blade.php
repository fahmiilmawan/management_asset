<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bolder mb-0">Data Pengaduan</h3>
            <p class="text-muted">{{ Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" wire:click="openModal">
                <i class="fas fa-plus"></i> Tambah Pengaduan
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
            <h5 class="mb-0 text-white">Daftar Pengaduan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Tanggal Rusak</th>
                            <th>Nama asset</th>
                            <th>Yang mengadukan </th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($isModalOpen)
    <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Pengaduan</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="asset_id" class="form-label">Pilih Asset</label>
                            <select wire:model="asset_id" id="asset_id" class="form-control">
                                <option value="">Pilih Asset</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('asset_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Pelapor</label>
                            <select wire:model="user_id" id="user_id" class="form-control">
                                <option value="">Pilih User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pengaduan" class="form-label">Pengaduan</label>
                            <input type="text" id="pengaduan" wire:model="pengaduan" class="form-control">
                            @error('pengaduan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" id="jumlah" wire:model="jumlah" class="form-control">
                            @error('jumlah') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select wire:model="status" id="status" class="form-control">
                                <option value="">Pilih Status</option>
                                <option value="diproses">Diproses</option>
                                <option value="sudah diperbaiki">Sudah Diperbaiki</option>
                            </select>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bukti_fisik" class="form-label">Bukti Fisik</label>
                            <input type="file" id="bukti_fisik" wire:model="bukti_fisik" class="form-control">
                            @error('bukti_fisik') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea id="deskripsi" wire:model="deskripsi" class="form-control"></textarea>
                            @error('deskripsi') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_rusak" class="form-label">Tanggal Rusak</label>
                            <input type="date" id="tanggal_rusak" wire:model="tanggal_rusak" class="form-control">
                            @error('tanggal_rusak') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endif

</div>
