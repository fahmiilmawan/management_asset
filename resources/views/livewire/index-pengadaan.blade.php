<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Pengadaan</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>

            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
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
        <div class="row m-3">
            <div class="col-md-4">
                <label for="" class="form-label">Cari</label>
                <input type="text" class="form-control" name="search" id="search" wire:model.live="search"
                    placeholder="Cari Nama Barang, Ruangan dan Status">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Ruangan</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        @if (Auth::user()->role == 'admin_umum')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengadaans as $pengadaan)
                        <tr>
                            <td>{{ $pengadaan->nama_barang_pengadaan }}</td>
                            <td>{{ $pengadaan->ruangan->nama_ruangan }}</td>
                            <td>{{ $pengadaan->jumlah_pengadaan }}</td>
                            <td>Rp.{{ number_format($pengadaan->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp.{{ number_format($pengadaan->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badge = match ($pengadaan->status_pengadaan) {
                                        'diajukan' => 'secondary',
                                        'diproses' => 'warning',
                                        'barang tiba' => 'success',
                                        'ditolak' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">
                                    {{ ucfirst($pengadaan->status_pengadaan) }}
                                </span>
                                @if (Auth::user()->role == 'admin_umum')
                                    @if (Auth::user()->role == 'admin_umum')
                                        <br>
                                        <span class="small">Status Aksi</span>
                                        <br>
                                        @if ($pengadaan->status_pengadaan == 'diajukan')
                                            <button class="btn btn-sm btn-warning"
                                                wire:click="updateStatus({{ $pengadaan->id }}, 'diproses')">Diproses</button>
                                            <button class="btn btn-sm btn-success"
                                                wire:click="updateStatus({{ $pengadaan->id }}, 'barang tiba')">Barang
                                                Tiba</button>
                                            <button class="btn btn-sm btn-danger"
                                                wire:click="updateStatus({{ $pengadaan->id }}, 'ditolak')">Ditolak</button>
                                        @elseif ($pengadaan->status_pengadaan == 'diproses')
                                            <button class="btn btn-sm btn-success"
                                                wire:click="updateStatus({{ $pengadaan->id }}, 'barang tiba')">Barang
                                                Tiba</button>
                                            <button class="btn btn-sm btn-danger"
                                                wire:click="updateStatus({{ $pengadaan->id }}, 'ditolak')">Ditolak</button>
                                        @elseif ($pengadaan->status_pengadaan == 'barang tiba' || $pengadaan->status_pengadaan == 'ditolak')
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    @endif
                            </td>


                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <!-- Lihat Detail -->
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalDetail"
                                                wire:click="detail({{ $pengadaan->id }})">
                                                <i class="bi bi-eye"></i> Lihat Detail
                                            </a>
                                        </li>
                                        <!-- Jika role adalah admin_umum -->
                                        @if (Auth::user()->role == 'admin_umum')
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editModal"
                                                    wire:click="edit({{ $pengadaan->id }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#modalDelete"
                                                    wire:click="confirmDelete({{ $pengadaan->id }})">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </li>
                                        @elseif (Auth::user()->role == 'staff_unit')
                                            <!-- Jika role adalah staff_unit -->
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editModal"
                                                    wire:click="edit({{ $pengadaan->id }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            </li>
                                        @endif
                    @endif
                    </ul>
        </div>
        </td>

        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">Tidak ada data pengadaan.</td>
        </tr>

        @endforelse
        </tbody>
        </table>
    </div>
    </div>
    <div class="card-footer">
        {{ $pengadaans->links() }}
    </div>
</div>

<!-- Modal Form -->
<div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="modalFormLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">
                        Tambah Pengadaan
                    </h5>
                </div>
                <div class="modal-body">
                    <!-- Input Fields -->

                    <div class="mb-3">
                        <label for="nama_barang_pengadaan" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control border p-2" id="nama_barang_pengadaan"
                            wire:model="nama_barang_pengadaan">
                        @error('nama_barang_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ruangan_id" class="form-label">Untuk Ruangan</label>
                        <select class="form-select p-2" id="ruangan_id" wire:model="ruangan_id">
                            <option value=""> Pilih Ruangan </option>
                            @foreach ($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @error('ruangan_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="satuan_pengadaan" class="form-label">Satuan</label>
                        <input type="text" class="form-control border p-2" id="satuan_pengadaan"
                            wire:model="satuan_pengadaan">
                        @error('satuan_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_pengadaan" class="form-label">Jumlah</label>
                        <input type="number" class="form-control border p-2" id="jumlah_pengadaan"
                            wire:model="jumlah_pengadaan">
                        @error('jumlah_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga_satuan" class="form-label">Harga Satuan</label>
                        <input type="number" class="form-control border p-2" id="harga_satuan"
                            wire:model="harga_satuan" wire:keyup="calculateTotal">
                        @error('harga_satuan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="number" class="form-control border p-2" id="total_harga"
                            wire:model="total_harga" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tahun_pengadaan" class="form-label">Tahun Pengadaan</label>
                        <input type="number" class="form-control border p-2" id="tahun_pengadaan"
                            wire:model="tahun_pengadaan">
                        @error('tahun_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                        <input type="date" class="form-control border p-2" id="tanggal_pengadaan"
                            wire:model="tanggal_pengadaan">
                        @error('tanggal_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" wire:model = "deskripsi" cols="5"
                            rows="5"></textarea>
                        @error('deskripsi')
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

<div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="modalFormLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="update">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">
                        Edit Pengadaan
                    </h5>
                </div>
                <div class="modal-body">
                    <!-- Input Fields -->

                    <div class="mb-3">
                        <label for="nama_barang_pengadaan" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control border p-2" id="nama_barang_pengadaan"
                            wire:model="nama_barang_pengadaan">
                        @error('nama_barang_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ruangan_id" class="form-label">Untuk Ruangan</label>
                        <select class="form-select p-2" id="ruangan_id" wire:model="ruangan_id">
                            <option value=""> Pilih Ruangan </option>
                            @foreach ($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @error('ruangan_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="satuan_pengadaan" class="form-label">Satuan</label>
                        <input type="text" class="form-control border p-2" id="satuan_pengadaan"
                            wire:model="satuan_pengadaan">
                        @error('satuan_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_pengadaan" class="form-label">Jumlah</label>
                        <input type="number" class="form-control border p-2" id="jumlah_pengadaan"
                            wire:model="jumlah_pengadaan">
                        @error('jumlah_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga_satuan" class="form-label">Harga Satuan</label>
                        <input type="number" class="form-control border p-2" id="harga_satuan"
                            wire:model="harga_satuan" wire:keyup="calculateTotal">
                        @error('harga_satuan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="number" class="form-control border p-2" id="total_harga"
                            wire:model="total_harga" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tahun_pengadaan" class="form-label">Tahun Pengadaan</label>
                        <input type="number" class="form-control border p-2" id="tahun_pengadaan"
                            wire:model="tahun_pengadaan">
                        @error('tahun_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                        <input type="date" class="form-control border p-2" id="tanggal_pengadaan"
                            wire:model="tanggal_pengadaan">
                        @error('tanggal_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="hidden" wire:model="status_pengadaan">
                        @error('status_pengadaan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" wire:model = "deskripsi" cols="5"
                            rows="5"></textarea>
                        @error('deskripsi')
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

@if (isset($pengadaan_id))
    <!-- Detail Modal -->
    <div wire:ignore.self class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalFormLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengadaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Informasi Pengadaan</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Nama Barang:</strong>
                                            <span>{{ $nama_barang_pengadaan ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Diajukan Oleh:</strong>
                                            <span>{{ $pengadaan->user->nama_lengkap ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Ruangan:</strong>
                                            <span>{{ $pengadaan->ruangan->nama_ruangan ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Satuan:</strong> <span>{{ $satuan_pengadaan ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Harga Satuan:</strong> <span>Rp.
                                                {{ number_format($harga_satuan, 0, ',', '.') ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Jumlah:</strong> <span>{{ $jumlah_pengadaan ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Total Harga:</strong> <span>Rp.
                                                {{ number_format($total_harga, 0, ',', '.') ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Tahun Pengadaan:</strong>
                                            <span>{{ $tahun_pengadaan ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Tanggal Pengadaan:</strong>
                                            <span>{{ $tanggal_pengadaan ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Status:</strong> <span
                                                class="badge bg-{{ $status_pengadaan == 'diterima' ? 'success' : 'warning' }}">{{ $status_pengadaan ?? '-' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Deskripsi</h6>
                                </div>
                                <div class="card-body">
                                    <p>{{ $deskripsi ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Detail Modal -->
@endif


<!-- Modal Delete -->
<div wire:ignore.self class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel"
    aria-hidden="true">
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
                <button type="button" class="btn btn-danger" wire:click="delete"
                    data-bs-dismiss="modal">Hapus</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    window.addEventListener('closeModal', event => {
        $('#addModal').modal('hide');
    })
    window.addEventListener('closeModal', event => {
        $('#editModal').modal('hide');
    })
</script>
