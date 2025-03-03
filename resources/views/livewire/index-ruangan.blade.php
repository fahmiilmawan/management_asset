<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Ruangan</h3>
            <p class="text-muted" id="real-time-clock">{{ Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        </div>
        @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'staff_unit')
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Tambah Ruangan
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
            <h5 class="mb-0">Daftar Ruangan</h5>
        </div>
        <div class="row m-3">
            <div class="col-md-6">
                <label for="" class="form-label">Cari</label>
                <input type="text" class="form-control" name="search" id="search" wire:model.live="search" placeholder="Cari Nama Ruangan">
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
                        <th>Nama Ruangan</th>
                        @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'staff_unit')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ( $ruangans as $index => $ruangan )
                    <tr>
                        <td>{{ $ruangans->firstItem() + $index }}</td>
                        <td>{{ $ruangan->nama_ruangan }}</td>
                        <td>
                            @if (Auth::user()->role == 'admin_umum')
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" wire:click="edit({{ $ruangan->id }})" data-bs-toggle="modal" data-bs-target="#editModal"> <i class="bi bi-pencil-square"></i> Edit</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" wire:click="confirmDelete({{ $ruangan->id }})" data-bs-toggle="modal" data-bs-target="#modalDelete"> <i class = "bi bi-trash"></i> Hapus</a></li>
                            </div>
                            @elseif (Auth::user()->role == 'staff_unit')
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" wire:click="edit({{ $ruangan->id }})">Edit</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data ruangan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $ruangans->links() }}
        </div>


    </div>
    {{-- End Render pagination --}}

    {{-- Modal Store Form --}}
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="store">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Tambah Ruangan
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                            <input type="text" class="form-control border p-2" id="nama_ruangan" wire:model="nama_ruangan">
                            @error('nama_ruangan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- End Modal Store Form --}}
    {{-- Modal Edit Form --}}
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="update">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Edit Ruangan
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                            <input type="text" class="form-control border p-2" id="nama_ruangan" wire:model="nama_ruangan">
                            @error('nama_ruangan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--End  Modal Edit Form --}}

    {{-- Modal Delete --}}
    <div wire:ignore.self class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-danger" wire:click="delete" data-bs-dismiss="modal">Hapus</button>
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
                        Import Ruangan
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
                            <a href="{{ route('export.template-ruangan') }}" class="btn btn-success">Download Template Import</a>
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
    });
    window.addEventListener('closeModal', event => {
        $('#editModal').modal('hide');
    });
    window.addEventListener('closeModal', event => {
        $('#importModal').modal('hide');
    });
</script>
