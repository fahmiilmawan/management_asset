<?php

namespace App\Livewire;

use App\Models\Asset;
use App\Models\Barang;
use App\Models\Pengaduan;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class IndexPengaduan extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $pengaduan_id, $asset_id, $user_id, $nama_pengaduan, $jumlah, $status,$status_barang, $bukti_fisik, $deskripsi, $tanggal_rusak, $search;



    public function render()
    {
        $pengaduans = Pengaduan::with('user', 'asset')->when(!Auth::user()->isAdmin(),function ($query){
            return $query->where('user_id', Auth::user()->id);
        })->paginate(5);

        if (empty($this->search)) {
            $pengaduans = Pengaduan::with('user', 'asset')->paginate(5);
        } elseif (trim($this->search) == '') {
            $pengaduans = Pengaduan::with('user', 'asset')->paginate(5);
        } else {
            $pengaduans = Pengaduan::with('user', 'asset')
                ->where('pengaduan', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('asset.barang', function ($q) {
                    $q->where('nama_barang', 'like', '%' . $this->search . '%')
                        ->orWhere('tanggal_rusak', 'like', '%' . $this->search . '%');
                })->paginate(5);
    };


        return view('livewire.index-pengaduan',[
            'pengaduans' => $pengaduans,
            'assets' => Asset::with('barang', 'ruangan', 'unit')->get(),
            'barangs' => Barang::all(),
        ]);
    }

    public function updateStatus($id, $status)
{
    // Cari pengaduan berdasarkan ID
    $pengaduan = Pengaduan::findOrFail($id);

    // Cari asset terkait pengaduan
    $asset = Asset::findOrFail($pengaduan->asset_id);


    if ($status === 'sudah diperbaiki') {
        // Update status pengaduan menjadi 'sudah diperbaiki' dan status_barang menjadi 'baik'
        $pengaduan->update([
            'status' => $status,
            'status_barang' => 'baik',
        ]);

        // Update jumlah pada model Asset
        $totalAsset = $asset->jumlah + $pengaduan->jumlah;
        $asset->update([
            'jumlah' => $totalAsset,
        ]);
    } else {
        // Jika status bukan 'sudah diperbaiki', update status dan status_barang
        $pengaduan->update([
            'status' => $status,
            'status_barang' => 'rusak',
        ]);
    }

    // Menampilkan pesan sukses
    session()->flash('message', 'Status pengaduan berhasil diubah menjadi ' . $status . '.');
}

    public function store()
    {
        try {
            $this->validate([
                'asset_id' => 'required',
                'nama_pengaduan' => 'required',
                'jumlah' => 'required',
                'deskripsi' => 'required',
                'tanggal_rusak' => 'required',
            ],
            [
                'asset_id.required' => 'Asset harus diisi.',
                'nama_pengaduan.required' => 'Pengaduan harus diisi.',
                'jumlah.required' => 'Jumlah harus diisi.',
                'deskripsi.required' => 'Deskripsi harus diisi.',
                'tanggal_rusak.required' => 'Tanggal rusak harus diisi.',
            ]);

            $bukti_fisik = $this->uploadBuktiFisik();
            DB::beginTransaction();
            $asset = Asset::findOrFail($this->asset_id);

            $jumlahAsset = $asset->jumlah;
            $jumlahPengaduan = $this->jumlah;

            if ($jumlahPengaduan > $jumlahAsset ) {
                $this->addError('jumlah', 'Jumlah pengaduan melebihi jumlah asset');
                throw new Exception('Jumlah pengaduan melebihi jumlah asset');
            }

            $hitungJumlah = $asset->jumlah - $this->jumlah;
            $asset->update([
                'jumlah' => $hitungJumlah
            ]);

            Pengaduan::create([
                'asset_id' => $this->asset_id,
                'user_id' => Auth::user()->id,
                'nama_pengaduan' => $this->nama_pengaduan,
                'jumlah' => $this->jumlah,
                'status' => 'diajukan',
                'status_barang' => 'rusak',
                'bukti_fisik' => $bukti_fisik,
                'deskripsi' => $this->deskripsi,
                'tanggal_rusak' => $this->tanggal_rusak,
            ]);

            DB::commit();
            session()->flash('message', 'Pengaduan berhasil ditambahkan.');

            $this->resetForm();
            $this->dispatch('closeModal');

        } catch (\Exception $e) {
            DB::rollBack();
        }




    }

    private function uploadBuktiFisik()
    {
        if ($this->bukti_fisik) {
            return $this->bukti_fisik->storeAs('bukti-fisik', $this->bukti_fisik->getClientOriginalName(),'public');
        }
        return null;
    }

    public function detail($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $this->pengaduan_id = $pengaduan->id;
        $this->asset_id = $pengaduan->asset_id;
        $this->user_id = $pengaduan->user_id;
        $this->nama_pengaduan = $pengaduan->nama_pengaduan;
        $this->jumlah = $pengaduan->jumlah;
        $this->status = $pengaduan->status;
        $this->status_barang = $pengaduan->status_barang;
        $this->bukti_fisik = $pengaduan->bukti_fisik;
        $this->deskripsi = $pengaduan->deskripsi;
        $this->tanggal_rusak = $pengaduan->tanggal_rusak;

    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $this->pengaduan_id = $pengaduan->id;
        $this->asset_id = $pengaduan->asset_id;
        $this->user_id = $pengaduan->user_id;
        $this->nama_pengaduan = $pengaduan->nama_pengaduan;
        $this->jumlah = $pengaduan->jumlah;
        $this->status = $pengaduan->status;
        $this->bukti_fisik = $pengaduan->bukti_fisik;
        $this->deskripsi = $pengaduan->deskripsi;
        $this->tanggal_rusak = $pengaduan->tanggal_rusak;
    }

    public function update()
    {

        $this->validate([
            'asset_id' => 'required',
            'nama_pengaduan' => 'required',
            'jumlah' => 'required',
            'deskripsi' => 'required',
            'tanggal_rusak' => 'required',
        ],
        [
            'asset_id.required' => 'Asset harus diisi.',
            'nama_pengaduan.required' => 'Pengaduan harus diisi.',
            'jumlah.required' => 'Jumlah harus diisi.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'tanggal_rusak.required' => 'Tanggal rusak harus diisi.',
        ]);

        $filePath = $this->uploadBuktiFisik();
        Pengaduan::find($this->pengaduan_id)->update([
            'asset_id' => $this->asset_id,
            'user_id' => $this->user_id,
            'nama_pengaduan' => $this->nama_pengaduan,
            'jumlah' => $this->jumlah,
            'status' => $this->status,
            'bukti_fisik' => $filePath,
            'deskripsi' => $this->deskripsi,
            'tanggal_rusak' => $this->tanggal_rusak,
        ]);

        $this->resetForm();

        session()->flash('message', 'Pengaduan berhasil diperbarui.');
        $this->dispatch('closeModal');
    }

    public function confirmDelete($id)
    {
        $this->pengaduan_id = $id;

    }

    public function delete()
    {
        Pengaduan::find($this->pengaduan_id)->delete();

        session()->flash('message', 'Pengaduan berhasil dihapus.');
    }


    public function resetForm()
    {
        $this->pengaduan_id = null;
        $this->asset_id = null;
        $this->user_id = null;
        $this->nama_pengaduan = '';
        $this->jumlah = '';
        $this->status = '';
        $this->bukti_fisik = '';
        $this->deskripsi = '';
        $this->tanggal_rusak = '';
    }
}
