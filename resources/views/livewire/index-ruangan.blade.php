<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Ruangan</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" wire:click="openModal">
                <i class="fas fa-plus"></i> Tambah Ruangan
            </button>
        </div>
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
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Ruangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data from render component --}}
                    @forelse ( $ruangans as $ruangan )
                    <tr>
                        <td>{{ $ruangan->nama_ruangan }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalForm" wire:click="edit({{ $ruangan->id }})">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete" wire:click="confirmDelete({{ $ruangan->id }})">Hapus</button>
                        </td>
                        @empty
                        <td colspan="2" class="text-center">Tidak ada data Ruangan.</td>
                        @endforelse
                    </tr>
                    {{-- End Looping data from render component --}}
                </tbody>
            </table>
        </div>

        {{-- Render pagination --}}
        <div class="card-footer">
            {{ $ruangans->links() }}
        </div>
    </div>
    {{-- End Render pagination --}}

    {{-- Modal Edit and Store Form --}}
    <div wire:ignore.self class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $ruangan_id ? 'update': 'store' }}">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $ruangan_id ? 'Edit Ruangan' : 'Tambah Ruangan' }}
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
                        <button type="submit" class="btn btn-primary">{{ $ruangan_id ? 'Simpan Perubahan' : 'Tambah' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--End Modal Edit and Store Form --}}

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
</div>
