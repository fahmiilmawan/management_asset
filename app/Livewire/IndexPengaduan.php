<?php

namespace App\Livewire;

use App\Models\Asset;
use App\Models\Barang;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class IndexPengaduan extends Component
{
use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $pengaduan_id, $asset_id, $user_id, $pengaduan, $jumlah, $status, $bukti_fisik, $deskripsi, $tanggal_rusak;

    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    protected $rules = [
        'pengaduan' => 'required',
        'jumlah' => 'required',
    ];

    protected $messages = [
        'pengaduan.required' => 'Pengaduan harus diisi.',
        'jumlah.required' => 'Jumlah harus diisi.',
    ];

    public function render()
    {
        return view('livewire.index-pengaduan',[
            'pengaduans' => Pengaduan::with('user', 'asset')->paginate(5),
            'assets' => Asset::with('barang', 'ruangan', 'unit')->get(),
            'barangs' => Barang::all(),
        ]);
    }

    public function store()
    {
        $this->validate();
        $filePath = $this->uploadBuktiFisik();

        Pengaduan::create([
            'asset_id' => $this->asset_id,
            'user_id' => Auth::user()->id,
            'pengaduan' => $this->pengaduan,
            'jumlah' => $this->jumlah,
            'status' => 'diproses',
            'bukti_fisik' => $filePath,
            'deskripsi' => $this->deskripsi,
            'tanggal_rusak' => $this->tanggal_rusak,
        ]);

        $this->resetForm();
        $this->isModalOpen = false;
        session()->flash('message', 'Pengaduan berhasil ditambahkan.');
    }

    private function uploadBuktiFisik()
    {
        if ($this->bukti_fisik) {
            return $this->bukti_fisik->storeAs('bukti-fisik', $this->bukti_fisik->getClientOriginalName());
        }
        return null;
    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $this->pengaduan_id = $pengaduan->id;
        $this->asset_id = $pengaduan->asset_id;
        $this->user_id = $pengaduan->user_id;
        $this->pengaduan = $pengaduan->pengaduan;
        $this->jumlah = $pengaduan->jumlah;
        $this->status = $pengaduan->status;
        $this->bukti_fisik = $pengaduan->bukti_fisik;
        $this->deskripsi = $pengaduan->deskripsi;
        $this->tanggal_rusak = $pengaduan->tanggal_rusak;
        $this->isModalOpen = true;
    }

    public function update()
    {
        $this->validate();
        $filePath = $this->uploadBuktiFisik();

        Pengaduan::find($this->pengaduan_id)->update([
            'asset_id' => $this->asset_id,
            'user_id' => $this->user_id,
            'pengaduan' => $this->pengaduan,
            'jumlah' => $this->jumlah,
            'status' => $this->status,
            'bukti_fisik' => $filePath,
            'deskripsi' => $this->deskripsi,
            'tanggal_rusak' => $this->tanggal_rusak,
        ]);

        $this->resetForm();
        $this->isModalOpen = false;
        session()->flash('message', 'Pengaduan berhasil diperbarui.');
    }

    public function confirmDelete($id)
    {
        $this->pengaduan_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        Pengaduan::find($this->pengaduan_id)->delete();
        $this->isDeleteModalOpen = false;
        session()->flash('message', 'Pengaduan berhasil dihapus.');
    }

    public function isModalOpen()
    {
        $this->isModalOpen = true;
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->pengaduan_id = null;
        $this->asset_id = null;
        $this->user_id = null;
        $this->pengaduan = '';
        $this->jumlah = '';
        $this->status = '';
        $this->bukti_fisik = '';
        $this->deskripsi = '';
        $this->tanggal_rusak = '';
    }
}
