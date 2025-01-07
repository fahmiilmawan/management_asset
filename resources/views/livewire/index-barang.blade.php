<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Barang</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>
        @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'staff_unit')
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Tambah Barang
                </button>
            </div>
        @endif
    </div>
    {{-- End of Header --}}

    {{-- Alert Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- End Alert Message --}}

    <!-- Tabel -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Barang</h5>

        </div>
        <div class="row m-3">
            <div class="col-md-6">
                <label for="search" class="form-label">Cari</label>
                <input type="text" class="form-control" name="search" id="search" wire:model.live="search"
                    placeholder="Cari Nama Barang">
            </div>
            <div class="col-md-6">
                <label for="search" class="form-label">Import</label>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bi bi-upload"></i> Import</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'staff_unit')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $index => $barang)
                        <tr>
                            <td>{{ $barangs->firstItem() + $index }}</td>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>
                                @if (Auth::user()->role == 'admin_umum')

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#editModal" wire:click="edit({{ $barang->id }})"><i
                                            class="bi bi-pencil-square"></i> Edit</a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalDelete"
                                            wire:click="confirmDelete({{ $barang->id }})"><i
                                            class="bi bi-trash"></i> Hapus</a>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </table>
            {{ $barangs->links() }}
        </div>

    </div>
    {{-- End Render pagination --}}

    {{-- Modal Store Form --}}
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">
                        Tambah Barang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form -->
                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input type="text" wire:model="kode_barang" class="form-control" id="kode_barang">
                            @error('kode_barang')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" wire:model="nama_barang" class="form-control" id="nama_barang">
                            @error('nama_barang')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Store Form --}}

    {{-- Modal Edit Form --}}
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">
                        Edit Barang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form -->
                    <form wire:submit.prevent="update">
                        <div class="mb-3">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input type="text" wire:model="kode_barang" class="form-control" id="kode_barang">
                            @error('kode_barang')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" wire:model="nama_barang" class="form-control" id="nama_barang">
                            @error('nama_barang')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Store Form --}}

    {{-- Modal Delete --}}
    <div wire:ignore.self class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Konfirmasi Hapus
                    </h5>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="delete"
                        data-bs-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Delete --}}
    {{-- Import Modal --}}
    <div wire:ignore.self class="modal fade" id="importModal" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Import Barang
                    </h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="import">
                        <div class="form-group">
                            <label for="file">File Excel</label>
                            <input type="file" wire:model="file" class="form-control">
                            @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Import</button>
                            <a href="{{ route('export.template-barang') }}" class="btn btn-success">Download Template Import</a>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Import Modal --}}
</div>
<script>

    window.addEventListener('closeModal', event => {
        $('#addModal').modal('hide');
        $('#editModal').modal('hide');
        $('#importModal').modal('hide');
    });
</script>
