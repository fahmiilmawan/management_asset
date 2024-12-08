<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data User</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" wire:click="openModal">
                <i class="fas fa-plus"></i> Tambah User
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
            <h5 class="mb-0">Daftar User</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Nama Unit</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data from render component --}}
                    @forelse ( $users as $user )
                    <tr>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->unit->nama_unit }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalForm" wire:click="edit({{ $user->id }})">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete" wire:click="confirmDelete({{ $user->id }})">Hapus</button>
                            <a class="btn btn-success btn-sm" href="{{ route('sendWhatsapp', $user->id) }}"> Kirim Password</a>
                        </td>
                        @empty
                        <td colspan="2" class="text-center">Tidak ada data user.</td>
                        @endforelse
                    </tr>
                    {{-- End Looping data from render component --}}
                </tbody>
            </table>
        </div>

        {{-- Render pagination --}}
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
    {{-- End Render pagination --}}

    {{-- Modal Edit and Store Form --}}
    <div wire:ignore.self class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $user_id ? 'update': 'store' }}">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $user_id ? 'Edit user' : 'Tambah user' }}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control border p-2" id="nama_lengkap" wire:model="nama_lengkap">
                            @error('nama_lengkap')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Unit</label>
                            <select class="form-select p-2 border" wire:model="unit_id" id="unit_id">
                                <option class="form-control" value=""> Pilih Unit </option>
                                @foreach ( $units as $unit )
                                <option class="form-control" value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                @endforeach
                            </select>
                            @error('unit_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="number" class="form-control border p-2" id="no_hp" wire:model="no_hp">
                            @error('no_hp')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control border p-2" id="email" wire:model="email">
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control border p-2" id="password" wire:model="password">
                            @error('password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select p-2 border" wire:model="role" id="">
                                <option> Pilih Role </option>
                                <option value="administrator">Administrator</option>
                                <option value="admin_umum">Admin Umum</option>
                                <option value="staff_unit">Staff Unit</option>
                            </select>
                            @error('role')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">{{ $user_id ? 'Simpan Perubahan' : 'Tambah' }}</button>
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
