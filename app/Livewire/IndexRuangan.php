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
        $this->validate([
            'nama_ruangan' => 'required'
        ],
        [
            'nama_ruangan.required' => 'Nama ruangan harus diisi.'
        ]);

        $ruangan = new Ruangan();
        $ruangan->nama_ruangan = $this->nama_ruangan;
        $ruangan->save();

        session()->flash('message', 'Ruangan berhasil ditambahkan.');

        $this->dispatch('closeModal');
    }

    // Function Edit Ruangan
    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $this->ruangan_id = $ruangan->id;
        $this->nama_ruangan = $ruangan->nama_ruangan;
    }

    // Function Update Ruangan
    public function update()
    {
        $this->validate([
            'nama_ruangan' => 'required'
        ],
        [
            'nama_ruangan.required' => 'Nama ruangan harus diisi.'
        ]);

        $ruangan = Ruangan::find($this->ruangan_id);
        $ruangan->update([
            'nama_ruangan' => $this->nama_ruangan
        ]);

        session()->flash('message', 'Ruangan berhasil diperbarui.');

        $this->dispatch('closeModal');
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

    }

    // Function Delete Ruangan
    public function delete()
    {
        $ruangan = Ruangan::findOrFail($this->ruangan_id);
        $ruangan->delete();

        session()->flash('message', 'Ruangan berhasil dihapus.');

    }
}
