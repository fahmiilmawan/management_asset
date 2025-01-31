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


    public $pengadaan_id, $user_id, $ruangan_id, $nama_barang_pengadaan, $satuan_pengadaan, $jumlah_pengadaan, $harga_satuan, $total_harga, $tahun_pengadaan, $tanggal_pengadaan, $status_pengadaan, $deskripsi, $search;

    public function render()
{
    $pengadaans = Pengadaan::with('ruangan')
        ->when(!Auth::user()->isAdmin(), function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->paginate(5);

    if (empty($this->search)) {
        $pengadaans = Pengadaan::with('ruangan')->paginate(5);
    } elseif (trim($this->search) == '') {
        $pengadaans = Pengadaan::with('ruangan')->paginate(5);
    } else {
        $pengadaans = Pengadaan::with('ruangan')
            ->where('nama_barang_pengadaan', 'like', '%' . $this->search . '%')
            ->orWhere('status_pengadaan', 'like', '%' . $this->search . '%')
            ->orWhereHas('ruangan', function ($q) {
                $q->where('nama_ruangan', 'like', '%' . $this->search . '%');
            })->paginate(5);
    }


    return view('livewire.index-pengadaan', [
        'pengadaans' => $pengadaans,
        'ruangans' => Ruangan::all(),
    ]);
}

public function updateStatus($id, $status_pengadaan)
{
    $pengadaan = Pengadaan::findOrFail($id);

    $pengadaan->update([
        'status_pengadaan' => $status_pengadaan,
    ]);
    session()->flash('message', 'Status pengadaan berhasil diperbarui menjadi ' . $status_pengadaan . '.');
}



    public function store()
    {
        $this->validate([
        'ruangan_id' => 'required|exists:ruangans,id',
        'nama_barang_pengadaan' => 'required|string|max:255',
        'satuan_pengadaan' => 'required|string|max:50',
        'jumlah_pengadaan' => 'required|integer|min:1',
        'harga_satuan' => 'required|numeric|min:0',
        'tahun_pengadaan' => 'required|digits:4',
        'tanggal_pengadaan' => 'required|date',
        ],
    [
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
    ]);

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
            'status_pengadaan' => $this->status_pengadaan = 'diajukan',
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Pengadaan berhasil ditambahkan.');

        $this->resetForm();
        $this->dispatch('closeModal');
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
        $this->deskripsi = $pengadaan->deskripsi;

    }

    public function detail($id)
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
        $this->deskripsi = $pengadaan->deskripsi;
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
        $this->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'nama_barang_pengadaan' => 'required|string|max:255',
            'satuan_pengadaan' => 'required|string|max:50',
            'jumlah_pengadaan' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'tahun_pengadaan' => 'required|digits:4',
            'tanggal_pengadaan' => 'required|date',
            ],
        [
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
        ]);

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
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Pengadaan berhasil diperbarui.');

        $this->dispatch('closeModal');
    }

    public function confirmDelete($id)
    {
        $this->pengadaan_id = $id;

    }

    public function delete()
    {
        $pengadaan = Pengadaan::findOrFail($this->pengadaan_id);
        $pengadaan->delete();

        session()->flash('message', 'Pengadaan berhasil dihapus.');
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
        $this->deskripsi ='' ;
    }
}
