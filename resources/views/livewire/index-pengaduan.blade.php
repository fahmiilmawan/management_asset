<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Pengaduan</h3>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" wire:click="openModal">
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
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal Rusak</th>
                        <th>Bukti Fisik</th>
                        <th>Nama Asset</th>
                        <th>Pengaduan</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data from render component --}}
                    @forelse ( $pengaduans as $pengaduan )
                    <tr>
                        <td>{{ $pengaduan->tanggal_rusak}}</td>
                        <td><img src="{{ \Illuminate\Support\Facades\Storage::url($pengaduan->bukti_fisik) }}" width="50px" height="50px" alt=""></td>
                        <td>{{ $pengaduan->asset->barang->nama_barang }}</td>
                        <td>{{ $pengaduan->pengaduan }}</td>
                        <td>{{ $pengaduan->jumlah }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalForm" wire:click="edit({{ $pengaduan->id }})">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete" wire:click="confirmDelete({{ $pengaduan->id }})">Hapus</button>
                        </td>
                        @empty
                        <td colspan="5" class="text-center">Tidak ada data pengaduan.</td>
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

    {{-- Modal Edit and Store Form --}}
    <div wire:ignore.self class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $pengaduan_id ? 'update': 'store' }}">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $pengaduan_id ? 'Edit Pengaduan' : 'Tambah Pengaduan' }}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" wire:model="user_id" value="{{ Auth::user()->id }}">
                        <div class="mb-3">
                            <label for="tanggal_rusak" class="form-label">Tanggal</label>
                            <input type="date" class="form-control border p-2" id="tanggal_rusak" wire:model="tanggal_rusak">
                            @error('tanggal_rusak')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="asset_id" class="form-label">Asset</label>
                            <select class="form-select border p-2" wire:model="asset_id" id="">
                                <option class="form-control" value=""> Pilih Asset </option>
                                @foreach ( $assets as $asset )
                                    <option class="form-control" value="{{ $asset->id }}">{{ $asset->barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('asset_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pengaduan" class="form-label">Pengaduan</label>
                            <input type="text" wire:model="pengaduan" class="form-control border p-2">
                            @error('pengaduan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control border p-2" id="jumlah" wire:model="jumlah">
                            @error('jumlah')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bukti_fisik" class="form-label">Bukti Fisik</label>
                            <input type="file" class="form-control border p-2" id="bukti_fisik" wire:model="bukti_fisik">
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
                        <button type="submit" class="btn btn-primary">{{ $pengaduan_id ? 'Simpan Perubahan' : 'Tambah' }}</button>
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
