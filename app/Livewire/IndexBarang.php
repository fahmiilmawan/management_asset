<?php

namespace App\Livewire;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;

class IndexBarang extends Component
{
    //Pagination
    use WithPagination;

    //Property Barang
    public $barang_id,$kode_barang, $nama_barang;

    //Property Modal
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    //Pagination Theme
    protected $paginationTheme = 'bootstrap';

    //Form Rules
    protected $rules = [
        'kode_barang' => 'required',
        'nama_barang' => 'required'
    ];

    //Form Validation Messages
    protected $messages = [
        'kode_barang.required' => 'Kode Barang Wajib Diisi',
        'nama_barang.required' => 'Nama Barang Wajib Diisi',
    ];


    //Render Component
    public function render()
    {
        return view('livewire.index-barang',[
            'barangs' => Barang::paginate(5),
        ]);
    }

    // Function Store Barang
    public function store()
    {
        $this->validate();

        Barang::create([
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
        ]);

        session()->flash('message', 'Barang berhasil ditambahkan.');

        $this->closeModal();
        $this->resetForm();
    }

    //Form Function Edit
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $this->barang_id = $barang->id;
        $this->kode_barang = $barang->kode_barang;
        $this->nama_barang = $barang->nama_barang;
        $this->isModalOpen = false;
    }

    // Function Update Barang
    public function update()
    {
        $this->validate();

        Barang::find($this->barang_id)->update([
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang
        ]);

        session()->flash('message', 'Barang berhasil diperbarui.');

        $this->closeModal();
    }

    // Function Open Modal
    public function openModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    //Function Close Modal
    public function closeModal()
    {
        $this->resetForm();
        $this->isModalOpen = false;
    }

    //Function Reset Form
    public function resetForm()
    {
        $this->barang_id = null;
        $this->kode_barang = '';
        $this->nama_barang = '';
    }

    //Function Delete Confirmation
    public function confirmDelete($id)
    {
        $this->barang_id = $id;
        $this->isDeleteModalOpen = true;
    }

    //Function Delete Barang
    public function delete()
    {
        $barang = Barang::findOrFail($this->barang_id);
        $barang->delete();

        session()->flash('message', 'Barang berhasil dihapus.');
        $this->isDeleteModalOpen = false;
    }

}
