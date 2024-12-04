<?php
namespace App\Livewire;

use App\Models\Asset;
use App\Models\Pengaduan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class IndexPengaduan extends Component
{
    use WithFileUploads;

    public $isModalOpen = false;

    // Form properties
    public $asset_id, $user_id, $pengaduan, $jumlah, $status, $bukti_fisik, $deskripsi, $tanggal_rusak;

    public function render()
    {
        return view('livewire.index-pengaduan', [
            'assets' => Asset::with(['ruangan', 'unit', 'barang'])->paginate(5),
            'users' => User::all(),
        ]);
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->isModalOpen = false;
    }

    public function store()
{
    $this->validate([
        'asset_id' => 'required|exists:assets,id',
        'user_id' => 'required|exists:users,id',
        'pengaduan' => 'required|string|max:255',
        'jumlah' => 'required|integer|min:1',
        'status' => 'required|in:diproses,sudah diperbaiki',
        'bukti_fisik' => 'nullable|file|max:2048', // tambahkan validasi file
        'deskripsi' => 'nullable|string',
        'tanggal_rusak' => 'required|date',
    ]);

    // Upload bukti fisik jika ada
    $buktiPath = null;
    if ($this->bukti_fisik) {
        $buktiPath = $this->bukti_fisik->storeAs('bukti-fisik', 'gambar-1');
    }

    // Simpan data pengaduan
    Pengaduan::create([
        'asset_id' => $this->asset_id,
        'user_id' => $this->user_id,
        'pengaduan' => $this->pengaduan,
        'jumlah' => $this->jumlah,
        'status' => $this->status,
        'bukti_fisik' => $buktiPath,
        'deskripsi' => $this->deskripsi,
        'tanggal_rusak' => $this->tanggal_rusak,
    ]);

    session()->flash('message', 'Pengaduan berhasil ditambahkan.');
    $this->reset(); // Reset semua field
    $this->closeModal();
}

    private function resetForm()
    {
        $this->asset_id = null;
        $this->user_id = null;
        $this->pengaduan = null;
        $this->jumlah = null;
        $this->status = null;
        $this->bukti_fisik = null;
        $this->deskripsi = null;
        $this->tanggal_rusak = null;
    }
}
