<?php

namespace App\Livewire;

use App\Models\Ruangan;
use Livewire\Component;
use Livewire\WithPagination;

class IndexRuangan extends Component
{
    // Pagination
    use WithPagination;

    // Pagination Theme Bootstrap
    protected $paginationTheme = 'bootstrap';

    // Property Ruangan
    public $ruangan_id, $nama_ruangan;

    // Property Modal
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    // Validation Rules
    protected $rules = [
        'nama_ruangan' => 'required',
    ];

    // Validation Messages
    protected $messages = [
        'nama_ruangan.required' => 'Nama ruangan harus diisi.',
    ];

    // Render Component
    public function render()
    {
        return view('livewire.index-ruangan', [
            'ruangans' => Ruangan::paginate(5),
        ]);
    }

    // Function Store Ruangan
    public function store()
    {
        $this->validate();

        Ruangan::create([
            'nama_ruangan' => $this->nama_ruangan,
        ]);

        session()->flash('message', 'Ruangan berhasil ditambahkan.');

        $this->closeModal();
        $this->resetForm();
    }

    // Function Edit Ruangan
    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $this->ruangan_id = $ruangan->id;
        $this->nama_ruangan = $ruangan->nama_ruangan;
        $this->isModalOpen = false;
    }

    // Function Update Ruangan
    public function update()
    {
        $this->validate();

        Ruangan::find($this->ruangan_id)->update([
            'nama_ruangan' => $this->nama_ruangan,
        ]);

        session()->flash('message', 'Ruangan berhasil diperbarui.');

        $this->closeModal();
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
        $this->ruangan_id = null;
        $this->nama_ruangan = '';
    }

    // Function Confirm Delete
    public function confirmDelete($id)
    {
        $this->ruangan_id = $id;
        $this->isDeleteModalOpen = true;
    }

    // Function Delete Ruangan
    public function delete()
    {
        $ruangan = Ruangan::findOrFail($this->ruangan_id);
        $ruangan->delete();

        session()->flash('message', 'Ruangan berhasil dihapus.');
        $this->isDeleteModalOpen = false;
    }
}
