<?php

namespace App\Livewire;

use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;

class IndexUnit extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['delete'];
    public $nama_unit,$deskripsi, $unit_id;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    protected $rules = [
        'nama_unit' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('livewire.index-unit', [
            'units' => Unit::paginate(5),
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
        $unit = Unit::findOrFail($id);
        $this->unit_id = $unit->id;
        $this->nama_unit = $unit->nama_unit;
        $this->deskripsi = $unit->deskripsi;
        $this->isModalOpen = true;
    }

    // Menyimpan data unit baru atau mengupdate data
    public function store()
    {
        $this->validate();

        if ($this->unit_id) {
            // Update unit
            $unit = Unit::find($this->unit_id);
            $unit->update([
                'nama_unit' => $this->nama_unit,
                'deskripsi' => $this->deskripsi,
            ]);
            session()->flash('message', 'Unit berhasil diperbarui.');
        } else {
            // Simpan barang baru
            Unit::create([
                'nama_unit' => $this->nama_unit,
                'deskripsi' => $this->deskripsi,
            ]);
            session()->flash('message', 'Unit berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    // Menghapus unit
    public function delete($id)
    {
    $unit = Unit::find($id);
    if ($unit) {
        $unit->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }
    }

    // Reset form input
    private function resetForm()
    {
        $this->nama_unit = '';
        $this->deskripsi = '';
        $this->unit_id = null;
    }
}
