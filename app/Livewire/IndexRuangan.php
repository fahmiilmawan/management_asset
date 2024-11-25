<?php

namespace App\Livewire;

use App\Models\Ruangan;
use Livewire\Component;
use Livewire\WithPagination;

class IndexRuangan extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['delete'];
    public $nama_ruangan, $ruangan_id;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    protected $rules = [
        'nama_ruangan' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('livewire.index-ruangan', [
            'ruangans' => Ruangan::paginate(5),
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
        $ruangan = Ruangan::findOrFail($id);
        $this->ruangan_id = $ruangan->id;
        $this->nama_ruangan = $ruangan->nama_ruangan;
        $this->isModalOpen = true;
    }

    // Menyimpan data barang baru atau mengupdate data
    public function store()
    {
        $this->validate();

        if ($this->ruangan_id) {
            // Update ruangan
            $ruangan = Ruangan::find($this->ruangan_id);
            $ruangan->update([
                'nama_ruangan' => $this->nama_ruangan,
            ]);
            session()->flash('message', 'Ruangan berhasil diperbarui.');
        } else {
            // Simpan barang baru
            Ruangan::create([
                'nama_ruangan' => $this->nama_ruangan,
            ]);
            session()->flash('message', 'Barang berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    // Menghapus ruangan
    public function delete($id)
    {
    $ruangan = Ruangan::find($id);
    if ($ruangan) {
        $ruangan->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }
    }

    // Reset form input
    private function resetForm()
    {
        $this->nama_ruangan = '';
        $this->ruangan_id = null;
    }
}
