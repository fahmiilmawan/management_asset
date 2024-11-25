<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bolder mb-0">Data User</h3>
            <p class="text-muted">{{ Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" wire:click="openModal">
                <i class="fas fa-plus"></i> Tambah User
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

    <!-- Tabel Data User -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary">
            <h5 class="mb-0 text-white">Daftar User</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Unit</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->nama_lengkap }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->unit->nama_unit ?? '-' }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning me-2" wire:click="edit({{ $user->id }})">
                                         Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger me-2" wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?">
                                         Hapus
                                    </button>
                                    <a href="{{ route('sendWhatsapp',$user->id) }}" target="_blank" class="btn btn-sm btn-success" >
                                        Kirim Password
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">{{ $user_id ? 'Edit User' : 'Tambah User' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3 p-3">
                        <form wire:submit.prevent="store">
                            <div class="mb-3">
                                <label for="unit_id" class="form-label">Unit</label>
                                <select id="unit_id" class="form-select" wire:model="unit_id">
                                    <option value="">Pilih Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                    @endforeach
                                </select>
                                @error('unit_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" wire:model="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
                                @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" wire:model="email" placeholder="Masukkan Email" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="text" class="form-control" id="no_hp" wire:model="no_hp" placeholder="Masukkan nomor telepon tanpa tanda +62" required>
                                </div>
                                @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" wire:model="password" placeholder="Masukkan Password" required>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" class="form-select" wire:model="role">
                                    <option value="">Pilih Role</option>
                                    <option value="administrator">Administrator</option>
                                    <option value="admin_umum">Admin Umum</option>
                                    <option value="staff_unit">Staff Unit</option>
                                </select>
                                @error('role') <small class="text-danger">{{ $message }}</small> @enderror
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

<script>
    window.addEventListener('open-whatsapp', event => {
        window.open(event.detail.url, '_blank');
    });
</script>
