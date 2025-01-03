<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data User</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
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
        <div class="row m-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari</label>
                <input type="text" class="form-control" name="search" id="search" wire:model.live="search" placeholder="Cari Nama User">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nama Unit</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data from render component --}}
                    @forelse ( $users as $index => $user )
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->unit->nama_unit }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal" wire:click="edit({{ $user->id }})"><i class="bi bi-pencil-square"></i> Edit</a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#modalDelete" wire:click="confirmDelete({{ $user->id }})"><i class="bi bi-trash"></i> Hapus</a>
                                    </li>
                                    <li>
                                        <a class="text-success dropdown-item" href="{{ route('sendWhatsapp', $user->id) }}"> <i class="bi bi-whatsapp"></i> Kirim Password</a>
                                    </li>
                                </ul>
                            </div>

                        </td>
                    </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data user.</td>
                        </tr>
                        @endforelse
                    </tr>
                    {{-- End Looping data from render component --}}
                </tbody>
            </table>
            {{ $users->links() }}
        </div>

        {{-- Render pagination --}}
        <div class="card-footer">
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
                            Tambah User
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
                            <input type="text" class="form-control border p-2" id="no_hp" wire:model="no_hp">
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
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--End Modal Store Form --}}
    {{-- Modal Edit Form --}}
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="update">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Edit User
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
                            <input type="text" class="form-control border p-2" id="no_hp" wire:model="no_hp">
                            <small class="text-danger">contoh : +628123456789</small>
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
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--End Modal Edit Form --}}

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
<script>
    window.addEventListener('closeModal', event => {
        $('#addModal').modal('hide');
    });
    window.addEventListener('closeModal', event => {
        $('#editModal').modal('hide');
    });
</script>
