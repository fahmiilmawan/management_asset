<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Pengaduan</h3>
            <p class="text-muted" id="real-time-clock">{{ Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        </div>

            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Tambah Pengaduan
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
            <h5 class="mb-0">Daftar Pengaduan</h5>
        </div>
        <div class="row m-3">
            <div class="col-md-4">
                <label for="" class="form-label">Cari</label>
                <input type="text" class="form-control" name="search" id="search" wire:model.live="search"
                    placeholder="Cari Nama Asset, Pengaduan, Tanggal Rusak dan Status">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal Rusak</th>
                        <th>Bukti Fisik</th>
                        <th>Nama Asset</th>
                        <th>Pengaduan</th>
                        <th>Jumlah</th>
                        <th class="text-center">Status</th>
                        @if (Auth::user()->role == 'admin_umum'|| Auth::user()->role == 'staff_unit')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data from render component --}}
                    @forelse ($pengaduans as $pengaduan)
                        <tr>
                            <td>{{ $pengaduan->tanggal_rusak }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $pengaduan->bukti_fisik) }}" class="popup-link">
                                    <img src="{{ asset('storage/' . $pengaduan->bukti_fisik) }}" width="50px" height="50px" alt="Bukti Fisik">
                                </a>
                            </td>
                            <td>{{ $pengaduan->asset->barang->nama_barang }}</td>
                            <td>{{ $pengaduan->nama_pengaduan }}</td>
                            <td>{{ $pengaduan->jumlah }}</td>

                            <td>
                                @php
                                    $badge = match ($pengaduan->status) {
                                        'diajukan' => 'secondary',
                                        'diproses' => 'warning',
                                        'sudah diperbaiki' => 'success',
                                        'ditolak' => 'danger',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                                <br>
                                @if (Auth::user()->role == 'admin_umum'|| Auth::user()->role == 'staff_unit' )

                                    <span class="small">Status Aksi</span>
                                    <br @if (Auth::user()->role == 'admin_umum') @if ($pengaduan->status == 'diajukan')
                            <button class="btn btn-sm btn-warning" wire:click="updateStatus({{ $pengaduan->id }}, 'diproses')">Diproses</button>
                            <button class="btn btn-sm btn-success" wire:click="updateStatus({{ $pengaduan->id }}, 'sudah diperbaiki')">Sudah Diperbaiki</button>
                            <button class="btn btn-sm btn-danger" wire:click="updateStatus({{ $pengaduan->id }}, 'ditolak')">Ditolak</button>
                            @elseif ($pengaduan->status == 'diproses')
                            <button class="btn btn-sm btn-success" wire:click="updateStatus({{ $pengaduan->id }}, 'sudah diperbaiki')">Sudah Diperbaiki</button>
                            <button class="btn btn-sm btn-danger" wire:click="updateStatus({{ $pengaduan->id }}, 'ditolak')">Ditolak</button>
                            @elseif ($pengaduan->status == 'sudah diperbaiki' || $pengaduan->status == 'ditolak')
                            <span class="badge bg-success">Selesai</span> @endif
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
                                                wire:click="detail({{ $pengaduan->id }})">
                                                <i class="bi bi-eye"></i> Lihat Detail
                                            </a>
                                        </li>
                                        <!-- Jika role adalah admin_umum -->
                                        @if (Auth::user()->role == 'admin_umum')
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editModal"
                                                    wire:click="edit({{ $pengaduan->id }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#modalDelete"
                                                    wire:click="confirmDelete({{ $pengaduan->id }})">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </li>
                                        @elseif (Auth::user()->role == 'staff_unit')
                                            <!-- Jika role adalah staff_unit -->
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editModal"
                                                    wire:click="edit({{ $pengaduan->id }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                    @endif

                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pengaduan.</td>
                        </tr>
                        @endforelse
                        </tr>
                        {{-- End Looping data from render component --}}
                    </tbody>
                </table>
            </div>

            {{-- Render pagination --}}
            <div class="card-footer">
                {{ $pengaduans->links() }}
            </div>
        </div>
        {{-- End Render pagination --}}

        {{-- Modal Store Form --}}
        <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="modalFormLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="store">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Tambah Pengaduan
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal_rusak" class="form-label">Tanggal</label>
                                <input type="date" class="form-control border p-2" id="tanggal_rusak"
                                    wire:model="tanggal_rusak">
                                @error('tanggal_rusak')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="asset_id" class="form-label">Asset</label>
                                <select class="form-select border p-2" wire:model="asset_id" id="">
                                    <option class="form-control" value=""> Pilih Asset </option>
                                    @foreach ($assets as $asset)
                                        <option class="form-control" value="{{ $asset->id }}">
                                            {{ $asset->barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                                @error('asset_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="pengaduan" class="form-label">Pengaduan</label>
                                <input type="text" wire:model="nama_pengaduan" class="form-control border p-2">
                                @error('nama_pengaduan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control border p-2" id="jumlah"
                                    wire:model="jumlah">
                                @error('jumlah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bukti_fisik" class="form-label">Bukti Fisik</label>
                                <input type="file" class="form-control border p-2" id="bukti_fisik"
                                    wire:model="bukti_fisik">
                                @error('bukti_fisik')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Kerusakan</label>
                                <textarea class="form-control border p-2" id="deskripsi" wire:model="deskripsi" cols="5" rows="5"></textarea>
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
        {{-- End Store Form --}}
        {{-- Modal Edit Form --}}
        <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="modalFormLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="update">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Edit Pengaduan
                            </h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" wire:model="user_id" value="{{ Auth::user()->id }}">
                            <div class="mb-3">
                                <label for="tanggal_rusak" class="form-label">Tanggal</label>
                                <input type="date" class="form-control border p-2" id="tanggal_rusak"
                                    wire:model="tanggal_rusak">
                                @error('tanggal_rusak')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="asset_id" class="form-label">Asset</label>
                                <select class="form-select border p-2" wire:model="asset_id" id="">
                                    <option class="form-control" value=""> Pilih Asset </option>
                                    @foreach ($assets as $asset)
                                        <option class="form-control" value="{{ $asset->id }}">
                                            {{ $asset->barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                                @error('asset_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="pengaduan" class="form-label">Pengaduan</label>
                                <input type="text" wire:model="nama_pengaduan" class="form-control border p-2">
                                @error('nama_pengaduan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control border p-2" id="jumlah"
                                    wire:model="jumlah">
                                @error('jumlah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bukti_fisik" class="form-label">Bukti Fisik</label>
                                <input type="file" class="form-control border p-2" id="bukti_fisik"
                                    wire:model="bukti_fisik">
                                @error('bukti_fisik')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Kerusakan</label>
                                <textarea class="form-control border p-2" id="deskripsi" wire:model="deskripsi" cols="5" rows="5"></textarea>
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
        {{-- End Edit Form --}}

        @if (isset($pengaduan))
            <!-- Detail Modal -->
            <div wire:ignore.self class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalFormLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Pengaduan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Informasi Pengaduan</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                @if ($pengaduan)
                                                    <li class="list-group-item">
                                                        <strong>Asset:</strong>
                                                        <span>{{ $pengaduan->asset->barang->nama_barang ?? '-' }}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Pengadu:</strong>
                                                        <span>{{ $pengaduan->user->nama_lengkap ?? '-' }}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Tanggal Rusak:</strong>
                                                        <span>{{ $pengaduan->tanggal_rusak ?? '-' }}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Jumlah:</strong>
                                                        <span>{{ $pengaduan->jumlah ?? '-' }}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Status:</strong> <span
                                                            class="badge bg-{{ $pengaduan->status == 'diproses' ? 'warning' : 'success' }}">{{ ucfirst($pengaduan->status) }}</span>
                                                    </li>
                                                @else
                                                    <li class="list-group-item">
                                                        <strong>Asset:</strong> <span>-</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Pengadu:</strong> <span>-</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Tanggal Rusak:</strong> <span>-</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Jumlah:</strong> <span>-</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Status:</strong> <span>-</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Detail Lainnya</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                @if ($pengaduan)
                                                    <li class="list-group-item">
                                                        <strong>Pengaduan:</strong>
                                                        <span>{{ $pengaduan->nama_pengaduan ?? '-' }}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Deskripsi:</strong>
                                                        <p>{{ $pengaduan->deskripsi ?? '-' }}</p>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Bukti Fisik:</strong>
                                                        @if ($pengaduan->bukti_fisik)
                                                            <img src="{{ asset('storage/' . $pengaduan->bukti_fisik) }}"
                                                                width="50px" height="50px" alt="">
                                                        @else
                                                            <span class="text-muted">Tidak ada</span>
                                                        @endif
                                                    </li>
                                                @else
                                                    <li class="list-group-item">
                                                        <strong>Pengaduan:</strong> <span>-</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Deskripsi:</strong> <span>-</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Bukti Fisik:</strong> <span>-</span>
                                                    </li>
                                                @endif
                                            </ul>
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
    </div>

    <script>
        window.addEventListener('closeModal', event => {
            $('#addModal').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#editModal').modal('hide');
        })

        $(document).ready(function() {
            $('.popup-link').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: {
                    verticalFit: true
                },
                closeBtnInside: true,
            });
        });
    </script>
