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

    // Property Modal
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    // Form Rules
    protected $rules = [
        'nama_unit' => 'required',
        'deskripsi' => 'required',
    ];

    // Form Validation Messages
    protected $messages = [
        'nama_unit.required' => 'Nama unit harus diisi.',
        'deskripsi.required' => 'Deskripsi harus diisi.',
    ];

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
        $this->validate();

        Unit::create([
            'nama_unit' => $this->nama_unit,
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Unit berhasil ditambahkan.');

        $this->resetForm();
        $this->isModalOpen = false;
    }

    // Form Function Edit
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $this->unit_id = $unit->id;
        $this->nama_unit = $unit->nama_unit;
        $this->deskripsi = $unit->deskripsi;
        $this->isModalOpen = true;
    }

    // Function Update Unit
    public function update()
    {
        $this->validate();

        Unit::find($this->unit_id)->update([
            'nama_unit' => $this->nama_unit,
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Unit berhasil diperbarui.');

        $this->closeModal();
    }

    // Function Delete Confirmation
    public function confirmDelete($id)
    {
        $this->unit_id = $id;
        $this->isDeleteModalOpen = true;
    }

    // Function Delete Unit
    public function delete()
    {
        $unit = Unit::findOrFail($this->unit_id);
        $unit->delete();

        session()->flash('message', 'Unit berhasil dihapus.');
        $this->isDeleteModalOpen = false;
    }

    // Function Open Modal
    public function openModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    // Function Close Modal
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // Function Reset Form
    public function resetForm()
    {
        $this->unit_id = null;
        $this->nama_unit = '';
        $this->deskripsi = '';
    }
}
