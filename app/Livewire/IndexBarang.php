<?php

namespace App\Livewire;

use App\Imports\BarangImport;
use App\Models\Barang;
use App\Models\User;
use Clockwork\Storage\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class IndexBarang extends Component
{
    //Pagination
    use WithPagination, WithFileUploads;

    //Property Barang
    public $barang_id, $kode_barang, $nama_barang, $file;
    public $search = '';

    //Pagination Theme
    protected $paginationTheme = 'bootstrap';

    //Render Component
    public function render()
    {
        // Query barang
        $barangs = Barang::query()
            ->when($this->search, function ($query) {
                // Jika ada nilai pencarian, filter data
                $query->where('kode_barang', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_barang', 'like', '%' . $this->search . '%');
            });

        // Mengembalikan view dengan data paginated
        return view('livewire.index-barang', [
            'barangs' => $barangs->paginate(5),
        ]);
    }

    // Fungsi untuk reset pagination ketika pencarian berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }


    // Function Store Barang
    public function store()
    {
        $this->validate(
            [
                'kode_barang' => 'required|unique:barangs,kode_barang',
                'nama_barang' => 'required'
            ],
            [
                'kode_barang.required' => 'Kode barang harus diisi.',
                'kode_barang.unique' => 'Kode barang sudah ada.',
                'nama_barang.required' => 'Nama barang harus diisi.'
            ]
        );

        $barang = new Barang();
        $barang->kode_barang = $this->kode_barang;
        $barang->nama_barang = $this->nama_barang;
        $barang->save();
        session()->flash('message', 'Barang berhasil ditambahkan.');

        $this->resetForm();
        $this->dispatch('closeModal');
    }

    private function resetForm()
    {
        $this->kode_barang = '';
        $this->nama_barang = '';
    }

    public function edit($id)
    {
        // $this->dispatch('showModal');
        $barang = Barang::findOrFail($id);
        $this->barang_id = $barang->id;
        $this->kode_barang = $barang->kode_barang;
        $this->nama_barang = $barang->nama_barang;
    }

    // // Function Update Barang
    public function update()
    {
        $this->validate(
            [
                'kode_barang' => 'required',
                'nama_barang' => 'required'
            ],
            [
                'kode_barang.required' => 'Kode barang harus diisi.',
                'nama_barang.required' => 'Nama barang harus diisi.'
            ]
        );

        Barang::find($this->barang_id)->update([
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang
        ]);

        session()->flash('message', 'Barang berhasil diperbarui.');

        $this->dispatch('closeModal');
    }

    //Function Delete Confirmation
    public function confirmDelete($id)
    {
        $this->barang_id = $id;
    }

    //Function Delete Barang
    public function delete()
    {
        $barang = Barang::findOrFail($this->barang_id);
        $barang->delete();

        session()->flash('message', 'Barang berhasil dihapus.');
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
            FacadesExcel::import(new BarangImport, $filePath);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            session()->flash('message', 'Barang berhasil diimport.');
        } catch (\Exception $e) {
            session()->flash('message', 'Barang gagal diimport. Error: ' . $e->getMessage());
        }
    }
}
