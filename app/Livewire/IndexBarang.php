<?php

namespace App\Livewire;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;

class IndexBarang extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

   
    public $kode_barang, $nama_barang, $barang_id;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    protected $rules = [
        'kode_barang' => 'required|string|max:255',
        'nama_barang' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('livewire.index-barang', [
            'barangs' => Barang::paginate(5),
        ]);
    }

    // Menampilkan modal untuk form tambah
    public function openModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    // Menutup modal
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // Menampilkan modal untuk form edit
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $this->barang_id = $barang->id;
        $this->kode_barang = $barang->kode_barang;
        $this->nama_barang = $barang->nama_barang;
        $this->isModalOpen = true;
    }

    // Menyimpan data barang baru atau mengupdate data
    public function store()
    {
        $this->validate();

        if ($this->barang_id) {
            // Update barang
            $barang = Barang::find($this->barang_id);
            $barang->update([
                'kode_barang' => $this->kode_barang,
                'nama_barang' => $this->nama_barang,
            ]);
            session()->flash('message', 'Barang berhasil diperbarui.');
        } else {
            // Simpan barang baru
            Barang::create([
                'kode_barang' => $this->kode_barang,
                'nama_barang' => $this->nama_barang,
            ]);
            session()->flash('message', 'Barang berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    // Menghapus barang
    public function delete($id)
    {
    $barang = Barang::find($id);
    if ($barang) {
        $barang->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }
    }

    // Reset form input
    private function resetForm()
    {
        $this->kode_barang = '';
        $this->nama_barang = '';
        $this->barang_id = null;
    }
}
