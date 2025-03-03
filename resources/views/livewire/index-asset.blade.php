<div class="container">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-0">Data Aset</h3>
            <p class="text-muted" id="real-time-clock">{{ Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        </div>
        @if (Auth::user()->role == 'admin_umum' || Auth::user()->role == 'staff_unit')

        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Tambah Aset
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
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">Daftar Aset</h5>
            </div>
        </div>
        <div class="row m-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari</label>
                <input type="text" class="form-control" name="search" id="search" wire:model.live="search" placeholder="Cari No Inventaris dan Nama Aset">
            </div>
            <div class="col-md-4">
                <div>
                    <label for="printQRCode" class="form-label">Print QR Code</label>
                </div>
                <a href="#" class="btn btn-primary" wire:click.prevent="printQRCode">Print QR Code</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No Inventaris</th>
                        <th>Nama Aset</th>
                        <th>Merk</th>
                        <th>Jumlah</th>
                        <th >QR Code</th>
                        @if (Auth::user()->role == 'admin_umum')

                        <th >Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data from render component --}}
                    @forelse ( $assets as $asset )
                    <tr>
                        <td>
                            <a href="#" wire:click="detail({{ $asset->id }})" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#modalDetail"> {{ $asset->no_urut }}/{{ $asset->no_inventaris }} </a>
                        </td>
                        <td>{{ $asset->barang->nama_barang }}</td>
                        <td>{{ $asset->merk }}</td>
                        <td>{{ $asset->jumlah }}</td>
                        <td>

                            <a href="" class="btn btn-info btn-sm" data-bs-target="#modalQRCode" data-bs-toggle="modal">QR Code</a>
                        </td>
                        @if (Auth::user()->role == 'admin_umum')
                        <td>
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" wire:click="edit({{ $asset->id }})" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bi bi-pencil-square"></i>Edit </a></li>
                                <li><a href="#" wire:click="confirmDelete({{ $asset->id }})" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#modalDelete"><i class="bi bi-trash"></i>Delete </a></li>
                            </ul>
                        </div>
                        @endif
                        </td>
                    </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tr>
                    {{-- End Looping data from render component --}}
                </tbody>
            </table>
            {{ $assets->links() }}
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
                            Tambah Aset
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">Nama aset</label>
                            <select class="form-select border p-2" wire:model="barang_id" id="barang_id">
                                <option class="form-control" value=""> Pilih Aset </option>
                                @foreach ( $barangs as $barang )
                                    <option class="form-control" value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('barang_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">Merk</label>
                            <input type="text" class="form-control border p-2" id="merk" wire:model="merk">
                            @error('merk')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Untuk Unit</label>
                            <select class="form-select border p-2" wire:model="unit_id" id="unit_id">
                                <option class="form-control" value=""> Untuk Unit </option>
                                @foreach ( $units as $unit )
                                <option class="form-control" value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                @endforeach
                            </select>
                            @error('unit_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ruangan_id" class="form-label">Untuk Ruangan</label>
                            <select class="form-select border p-2" wire:model="ruangan_id" id="ruangan_id">
                                <option class="form-control" value=""> Pilih Ruangan </option>
                                @foreach ( $ruangans as $ruangan )
                                <option class="form-control" value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                                @endforeach
                            </select>
                            @error('ruangan_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select class="form-select border p-2" wire:model="bulan" id="bulan">
                                        <option value=""> Pilih Bulan</option>
                                        @foreach ($bulanRomawi as $bulan => $romawi)
                                            <option value="{{ $bulan }}">{{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                    @error('bulan')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" class="form-control border p-2" id="tahun" wire:model="tahun">
                                    @error('tahun')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <input type="hidden" class="form-control border p-2" id="no_inventaris" wire:model="no_inventaris" readonly>
                        </div>


                        <div class="mb-4">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select class="form-select border p-2" wire:model="satuan" id="">
                                <option value="">Pilih Satuan</option>
                                <option value="unit">Unit</option>
                                <option value="unit">Rim</option>
                                <option value="unit">Box</option>
                                <option value="unit">Pcs</option>
                                <option value="unit">Meter</option>
                                <option value="unit">Lusin</option>
                                <option value="unit">Roll</option>
                                <option value="unit">Set</option>
                            </select>
                            @error('satuan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control border p-2" id="jumlah" wire:model="jumlah">
                            @error('jumlah')
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
                            Edit
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">Nama aset</label>
                            <select class="form-select border p-2" wire:model="barang_id" id="barang_id">
                                <option class="form-control" value=""> Pilih Aset </option>
                                @foreach ( $barangs as $barang )
                                    <option class="form-control" value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('barang_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">Merk</label>
                            <input type="text" class="form-control border p-2" id="merk" wire:model="merk">
                            @error('merk')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Untuk Unit</label>
                            <select class="form-select border p-2" wire:model="unit_id" id="unit_id">
                                <option class="form-control" value=""> Untuk Unit </option>
                                @foreach ( $units as $unit )
                                <option class="form-control" value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                @endforeach
                            </select>
                            @error('unit_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ruangan_id" class="form-label">Untuk Ruangan</label>
                            <select class="form-select border p-2" wire:model="ruangan_id" id="ruangan_id">
                                <option class="form-control" value=""> Pilih Ruangan </option>
                                @foreach ( $ruangans as $ruangan )
                                <option class="form-control" value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                                @endforeach
                            </select>
                            @error('ruangan_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select class="form-select border p-2" wire:model="bulan" id="bulan">
                                        <option value=""> Pilih Bulan</option>
                                        @foreach ($bulanRomawi as $bulan => $romawi)
                                            <option value="{{ $bulan }}">{{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                    @error('bulan')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" class="form-control border p-2" id="tahun" wire:model="tahun">
                                    @error('tahun')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <input type="hidden" class="form-control border p-2" id="no_inventaris" wire:model="no_inventaris" readonly>
                        </div>


                        <div class="mb-4">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select class="form-select border p-2" wire:model="satuan" id="">
                                <option value="">Pilih Satuan</option>
                                <option value="unit">Unit</option>
                                <option value="unit">Rim</option>
                                <option value="unit">Box</option>
                                <option value="unit">Pcs</option>
                                <option value="unit">Meter</option>
                                <option value="unit">Lusin</option>
                                <option value="unit">Roll</option>
                                <option value="unit">Set</option>
                                <option value="unit">Kardus</option>
                            </select>
                            @error('satuan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="status" class="form-label">status</label>
                            <select class="form-select border p-2" wire:model="status" id="">
                                <option value="">Pilih Status</option>
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                            </select>
                            @error('status')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control border p-2" id="jumlah" wire:model="jumlah">
                            @error('jumlah')
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


    @if (isset($asset))
    <!-- Detail Modal -->
    <div wire:ignore.self class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel">Detail Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Informasi Aset</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Barang:</strong> <span>{{ $asset->barang->nama_barang }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>No Inventaris:</strong> <span>{{$asset->no_urut}}/{{ $asset->no_inventaris }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Bulan:</strong> <span>{{ $asset->bulan }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Tahun:</strong> <span>{{ $asset->tahun }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Jumlah:</strong> <span>{{ $asset->jumlah }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Satuan:</strong> <span>{{ $asset->satuan }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Status:</strong> <span class="badge bg-{{ $asset->status == 'baik' ? 'success' : 'danger' }}">{{ ucfirst($asset->status) }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Lokasi Aset</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Ruangan:</strong> <span>{{ $asset->ruangan->nama_ruangan }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Unit:</strong> <span>{{ $asset->unit->nama_unit }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-4 text-center">
                                    <h6 class="mb-3">QR Code</h6>
                                    <div>
                                        <img src="{{ $this->generate($asset->no_inventaris) }}">
                                    </div>
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
    {{-- QRModal --}}
    <div wire:ignore.self class="modal fade" id="modalQRCode" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        QR Code
                    </h5>
                </div>
                <div class="modal-body">
                    <img src="{{ $this->generate($asset->no_inventaris) }}">
                    <span>
                        {{ $asset->no_urut.'/'.$asset->no_inventaris }}
                    </span>
                </div>
                <div class="modal-footer">
                    <a href="{{ $this->generate($asset->no_inventaris) }}" download="{{ $asset->no_inventaris }}" class="btn btn-primary">Download</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End QR Modal --}}
    @endif

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
    })
    window.addEventListener('closeModal', event => {
        $('#editModal').modal('hide');
    })

</script>
