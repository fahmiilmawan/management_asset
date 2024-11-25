<?php

namespace App\Livewire;

use App\Models\Asset;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;

class IndexAsset extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $asset_id, $barang_id, $ruangan_id, $unit_id, $no_inventaris;
    public $bulan, $tahun, $satuan, $status, $jumlah;
    public $isModalOpen = false;
    public $selectedBarang;
    public $selectedAsset;
    public $isDetailModalOpen =false;

    protected $rules = [
        'barang_id' => 'required',
        'ruangan_id' => 'required',
        'unit_id' => 'required',
        'bulan' => 'required|string',
        'tahun' => 'required|integer',
        'satuan' => 'required|string',
        'status' => 'required|in:baik,rusak',
        'jumlah' => 'required|integer',
    ];

    public function updatedBarangId($value)
    {
        if ($value) {
            $this->selectedBarang = Barang::find($value);
            $this->generateNoInventaris();
        }
    }

    public function updatedBulan($value)
    {
        $this->generateNoInventaris();
    }

    public function updatedTahun($value)
    {
        $this->generateNoInventaris();
    }

    private function generateNoInventaris()
    {
        if ($this->selectedBarang && $this->bulan && $this->tahun) {
            $this->no_inventaris = sprintf(
                "%d/%s/%s/%d",
                $this->selectedBarang->id,
                $this->selectedBarang->kode_barang,
                $this->bulan,
                $this->tahun
            );
        }
    }

    public function render()
    {
        return view('livewire.index-asset', [
            'assets' => Asset::with(['barang', 'ruangan', 'unit'])->paginate(5),
            'barangs' => Barang::all(),
            'ruangans' => Ruangan::all(),
            'units' => Unit::all(),
        ]);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $this->asset_id = $asset->id;
        $this->barang_id = $asset->barang_id;
        $this->ruangan_id = $asset->ruangan_id;
        $this->unit_id = $asset->unit_id;
        $this->no_inventaris = $asset->no_inventaris;
        $this->bulan = $asset->bulan;
        $this->tahun = $asset->tahun;
        $this->satuan = $asset->satuan;
        $this->status = $asset->status;
        $this->jumlah = $asset->jumlah;
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'barang_id' => $this->barang_id,
            'ruangan_id' => $this->ruangan_id,
            'unit_id' => $this->unit_id,
            'no_inventaris' => $this->no_inventaris,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'satuan' => $this->satuan,
            'status' => $this->status,
            'jumlah' => $this->jumlah,
        ];

        if ($this->asset_id) {
            Asset::find($this->asset_id)->update($data);
            session()->flash('message', 'Asset berhasil diperbarui.');
        } else {
            Asset::create($data);
            session()->flash('message', 'Asset berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $asset = Asset::find($id);
        if ($asset) {
            $asset->delete();
            session()->flash('message', 'Asset berhasil dihapus.');
        }
    }

    private function resetForm()
    {
        $this->asset_id = null;
        $this->barang_id = '';
        $this->ruangan_id = '';
        $this->unit_id = '';
        $this->no_inventaris = '';
        $this->bulan = '';
        $this->tahun = '';
        $this->satuan = '';
        $this->status = '';
        $this->jumlah = '';
    }

    public function showDetail($assetId)
    {

        $this->selectedAsset = Asset::find($assetId);

        $this->isDetailModalOpen = true;
    }
    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedAsset = null; 
    }
}
