<?php

namespace App\Livewire;

use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;

class IndexUnit extends Component
{
    // Pagination
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Property Unit
    public $unit_id, $nama_unit, $deskripsi;


    // Render Component
    public function render()
    {
        return view('livewire.index-unit', [
            'units' => Unit::paginate(5),
        ]);
    }

    // Function Store Unit
    public function store()
    {
        $this->validate([
            'nama_unit' => 'required',
            'deskripsi' => 'required'
        ],
        [
            'nama_unit.required' => 'Nama unit harus diisi.',
            'deskripsi.required' => 'Deskripsi harus diisi.'
        ]);

        $unit = new Unit();
        $unit->nama_unit = $this->nama_unit;
        $unit->deskripsi = $this->deskripsi;
        $unit->save();

        session()->flash('message', 'Unit berhasil ditambahkan.');

        $this->dispatch('closeModal');
    }

    // Form Function Edit
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $this->unit_id = $unit->id;
        $this->nama_unit = $unit->nama_unit;
        $this->deskripsi = $unit->deskripsi;
    }

    // Function Update Unit
    public function update()
    {
        $this->validate([
            'nama_unit' => 'required',
            'deskripsi' => 'required'
        ],
        [
            'nama_unit.required' => 'Nama unit harus diisi.',
            'deskripsi.required' => 'Deskripsi harus diisi.'
        ]);

        $unit = Unit::findOrFail($this->unit_id);
        $unit->update([
            'nama_unit' => $this->nama_unit,
            'deskripsi' => $this->deskripsi
        ]);

        session()->flash('message', 'Unit berhasil diubah.');

        $this->dispatch('closeModal');
    }

    // Function Delete Confirmation
    public function confirmDelete($id)
    {
        $this->unit_id = $id;
    }

    // Function Delete Unit
    public function delete()
    {
        $unit = Unit::findOrFail($this->unit_id);
        $unit->delete();

        session()->flash('message', 'Unit berhasil dihapus.');

    }


    // Function Reset Form
    public function resetForm()
    {
        $this->unit_id = null;
        $this->nama_unit = '';
        $this->deskripsi = '';
    }
}
