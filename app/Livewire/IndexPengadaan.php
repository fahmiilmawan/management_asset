<?php

namespace App\Livewire;

use App\Models\Pengadaan;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPengadaan extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['confirmDelete'];

    public $pengadaan_id, $user_id, $ruangan_id, $nama_barang_pengadaan, $satuan_pengadaan, $jumlah_pengadaan, $harga_satuan, $total_harga, $tahun_pengadaan, $tanggal_pengadaan, $status_pengadaan;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    protected $rules = [
        'ruangan_id' => 'required|exists:ruangans,id',
        'nama_barang_pengadaan' => 'required|string|max:255',
        'satuan_pengadaan' => 'required|string|max:50',
        'jumlah_pengadaan' => 'required|integer|min:1',
        'harga_satuan' => 'required|numeric|min:0',
        'tahun_pengadaan' => 'required|digits:4',
        'tanggal_pengadaan' => 'required|date',
        'status_pengadaan' => 'required|in:diterima,diproses,barang tiba',
    ];

    protected $messages = [
        'ruangan_id.required' => 'Ruangan harus dipilih.',
        'ruangan_id.exists' => 'Ruangan tidak ditemukan.',
        'nama_barang_pengadaan.required' => 'Nama barang pengadaan harus diisi.',
        'satuan_pengadaan.required' => 'Satuan pengadaan harus diisi.',
        'jumlah_pengadaan.required' => 'Jumlah pengadaan harus diisi.',
        'jumlah_pengadaan.integer' => 'Jumlah pengadaan harus berupa angka.',
        'jumlah_pengadaan.min' => 'Jumlah pengadaan minimal adalah 1.',
        'harga_satuan.required' => 'Harga satuan harus diisi.',
        'harga_satuan.numeric' => 'Harga satuan harus berupa angka.',
        'harga_satuan.min' => 'Harga satuan minimal adalah 0.',
        'tahun_pengadaan.required' => 'Tahun pengadaan harus diisi.',
        'tahun_pengadaan.digits' => 'Tahun pengadaan harus terdiri dari 4 angka.',
        'tanggal_pengadaan.required' => 'Tanggal pengadaan harus diisi.',
        'tanggal_pengadaan.date' => 'Tanggal pengadaan harus berupa tanggal.',
        'status_pengadaan.required' => 'Status pengadaan harus dipilih.',
        'status_pengadaan.in' => 'Status pengadaan tidak valid.',
    ];

    public function render()
    {
        return view('livewire.index-pengadaan', [
            'pengadaans' => Pengadaan::with('ruangan')->paginate(5),
            'ruangans' => Ruangan::all(),
        ]);
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

    public function edit($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);

        $this->pengadaan_id = $pengadaan->id;
        $this->user_id = $pengadaan->user_id;
        $this->ruangan_id = $pengadaan->ruangan_id;
        $this->nama_barang_pengadaan = $pengadaan->nama_barang_pengadaan;
        $this->satuan_pengadaan = $pengadaan->satuan_pengadaan;
        $this->jumlah_pengadaan = $pengadaan->jumlah_pengadaan;
        $this->harga_satuan = $pengadaan->harga_satuan;
        $this->total_harga = $pengadaan->total_harga;
        $this->tahun_pengadaan = $pengadaan->tahun_pengadaan;
        $this->tanggal_pengadaan = $pengadaan->tanggal_pengadaan;
        $this->status_pengadaan = $pengadaan->status_pengadaan;

        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        $this->total_harga = $this->jumlah_pengadaan * $this->harga_satuan;

        Pengadaan::create([
            'user_id' => Auth::user()->id,
            'ruangan_id' => $this->ruangan_id,
            'nama_barang_pengadaan' => $this->nama_barang_pengadaan,
            'satuan_pengadaan' => $this->satuan_pengadaan,
            'jumlah_pengadaan' => $this->jumlah_pengadaan,
            'harga_satuan' => $this->harga_satuan,
            'total_harga' => $this->total_harga,
            'tahun_pengadaan' => $this->tahun_pengadaan,
            'tanggal_pengadaan' => $this->tanggal_pengadaan,
            'status_pengadaan' => 'diproses',
        ]);

        session()->flash('message', 'Pengadaan berhasil ditambahkan.');

        $this->closeModal();
        $this->resetForm();
    }

    public function calculateTotal()
{
    if ($this->jumlah_pengadaan && $this->harga_satuan) {
        $this->total_harga = $this->jumlah_pengadaan * $this->harga_satuan;
    } else {
        $this->total_harga = 0;
    }
}


    public function update()
    {
        $this->validate();

        $pengadaan = Pengadaan::findOrFail($this->pengadaan_id);

        $pengadaan->update([
            'user_id' => Auth::user()->id,
            'ruangan_id' => $this->ruangan_id,
            'nama_barang_pengadaan' => $this->nama_barang_pengadaan,
            'satuan_pengadaan' => $this->satuan_pengadaan,
            'jumlah_pengadaan' => $this->jumlah_pengadaan,
            'harga_satuan' => $this->harga_satuan,
            'total_harga' => $this->jumlah_pengadaan * $this->harga_satuan,
            'tahun_pengadaan' => $this->tahun_pengadaan,
            'tanggal_pengadaan' => $this->tanggal_pengadaan,
            'status_pengadaan' => $this->status_pengadaan,
        ]);

        session()->flash('message', 'Pengadaan berhasil diperbarui.');

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->pengadaan_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        $pengadaan = Pengadaan::findOrFail($this->pengadaan_id);
        $pengadaan->delete();

        session()->flash('message', 'Pengadaan berhasil dihapus.');
        $this->isDeleteModalOpen = false;
    }

    private function resetForm()
    {
        $this->pengadaan_id = null;
        $this->user_id = null;
        $this->ruangan_id = null;
        $this->nama_barang_pengadaan = '';
        $this->satuan_pengadaan = '';
        $this->jumlah_pengadaan = null;
        $this->harga_satuan = null;
        $this->total_harga = null;
        $this->tahun_pengadaan = null;
        $this->tanggal_pengadaan = null;
        $this->status_pengadaan = '';
    }
}
