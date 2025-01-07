<?php

namespace App\Livewire;

use App\Imports\RuanganImport;
use App\Models\Ruangan;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class IndexRuangan extends Component
{
    // Pagination
    use WithPagination, WithFileUploads;

    // Pagination Theme Bootstrap
    protected $paginationTheme = 'bootstrap';

    // Property Ruangan
    public $ruangan_id, $nama_ruangan, $file;
    public $search = '';

    // Render Component
    public function render()
    {
        $ruangans = Ruangan::query()
            ->when($this->search, function ($query) {
                $query->where('nama_ruangan', 'like', '%' . $this->search . '%');
            });

        return view('livewire.index-ruangan', [
            'ruangans' => $ruangans->paginate(5), // Pagination dengan 5 item per halaman
        ]);
    }

    // Reset pagination saat pencarian berubah
    public function updatedSearch()
    {
        $this->resetPage();
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

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:csv,xls,xlsx',
        ], [
            'file.required' => 'File harus diisi.',
            'file.mimes' => 'Format file harus CSV, XLS, atau XLSX.',
        ]);


        $file = $this->file;
        $filename = $file->getClientOriginalName();
        $path = $file->storeAs('excel/', $filename);


        $filePath = public_path('storage/excel/' . $filename);

        try {
            FacadesExcel::import(new RuanganImport, $filePath);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            session()->flash('message', 'Barang berhasil diimport.');

            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            session()->flash('message', 'Barang gagal diimport. Error: ' . $e->getMessage());
        }
    }
}
