<?php

namespace App\Livewire;

use App\Helper\QRCode;
use App\Imports\AssetsImport;
use App\Models\Asset;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class IndexAsset extends Component
{
    use WithPagination, WithFileUploads;


    protected $paginationTheme = 'bootstrap';

    public $asset_id, $barang_id,$merk, $ruangan_id, $unit_id,$no_urut, $no_inventaris, $bulan, $tahun, $satuan, $jumlah, $search;
    public $status = 'baik';
    public $file;

    protected $bulanRomawi = [
        'Januari' => 'I',
        'Februari' => 'II',
        'Maret' => 'III',
        'April' => 'IV',
        'Mei' => 'V',
        'Juni' => 'VI',
        'Juli' => 'VII',
        'Agustus' => 'VIII',
        'September' => 'IX',
        'Oktober' => 'X',
        'November' => 'XI',
        'Desember' => 'XII',
    ];


    public function render()
    {
        $query = Asset::with('barang', 'ruangan', 'unit');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('no_inventaris', 'like', '%' . $this->search . '%')
                  ->orWhereHas('barang', function ($q) {
                      $q->where('nama_barang', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('unit', function ($q) {
                      $q->where('nama_unit', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('ruangan', function ($q) {
                      $q->where('nama_ruangan', 'like', '%' . $this->search . '%');
                  });
            });
        }

        return view('livewire.index-asset',[
            'assets' => $query->paginate(5),
            'barangs' => Barang::all(),
            'ruangans' => Ruangan::all(),
            'units' => Unit::all(),
            'bulanRomawi' => $this->bulanRomawi
        ]);
    }

    public function store()
    {
        $this->validate([
            'barang_id' => 'required',
            'merk' => 'required',
            'ruangan_id' => 'required',
            'unit_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'satuan' => 'required',
            'status' => 'required',
            'jumlah' => 'required'
        ],
        [
            'barang_id.required' => 'Barang harus diisi.',
            'merk.required' => 'Merk harus diisi.',
            'ruangan_id.required' => 'Ruangan harus diisi.',
            'unit_id.required' => 'Unit harus diisi.',
            'bulan.required' => 'Bulan harus diisi.',
            'tahun.required' => 'Tahun harus diisi.',
            'satuan.required' => 'Satuan harus diisi.',
            'status.required' => 'Status harus diisi.',
            'jumlah.required' => 'Jumlah harus diisi.'
        ]);


        $noUrut = Asset::max('no_urut') ?? 0;
        $newNoUrut = $noUrut + 1;

        $asset = new Asset();
        $asset->barang_id = $this->barang_id;
        $asset->merk = $this->merk;
        $asset->ruangan_id = $this->ruangan_id;
        $asset->unit_id = $this->unit_id;
        $asset->no_urut = $newNoUrut;
        $asset->no_inventaris = $this->no_inventaris;
        $asset->bulan = $this->bulan;
        $asset->tahun = $this->tahun;
        $asset->satuan = $this->satuan;
        $asset->status = $this->status;
        $asset->jumlah = $this->jumlah;
        $asset->save();

        $this->resetForm();

        session()->flash('message', 'Asset berhasil ditambahkan.');
        $this->dispatch('closeModal');
    }

    private function generateNoInventaris()
    {
        if ( $this->bulan && $this->tahun) {

            $barang = Barang::find($this->barang_id);
            $kodeBarang = $barang ? $barang->kode_barang : 'N/A';

            $bulanRomawi = $this->bulanRomawi[$this->bulan];
            $this->no_inventaris = "{$kodeBarang}/{$bulanRomawi}/{$this->tahun}";
        }
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['barang_id', 'bulan', 'tahun'])) {
            $this->generateNoInventaris();
        }
    }

    public function generate($no_inventaris)
    {
        $QRcode = new QRCode($no_inventaris);
        return $QRcode->generate();

    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $this->asset_id = $asset->id;
        $this->barang_id = $asset->barang_id;
        $this->merk = $asset->merk;
        $this->ruangan_id = $asset->ruangan_id;
        $this->unit_id = $asset->unit_id;
        $this->no_inventaris = $asset->no_inventaris;
        $this->bulan = $asset->bulan;
        $this->tahun = $asset->tahun;
        $this->satuan = $asset->satuan;
        $this->status = $asset->status;
        $this->jumlah = $asset->jumlah;

    }

    public function update()
    {
        $this->validate([
            'barang_id' => 'required',
            'merk' => 'required',
            'ruangan_id' => 'required',
            'unit_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'satuan' => 'required',
            'status' => 'required',
            'jumlah' => 'required'
        ],
        [
            'barang_id.required' => 'Barang harus diisi.',
            'merk.required' => 'Merk harus diisi.',
            'ruangan_id.required' => 'Ruangan harus diisi.',
            'unit_id.required' => 'Unit harus diisi.',
            'bulan.required' => 'Bulan harus diisi.',
            'tahun.required' => 'Tahun harus diisi.',
            'satuan.required' => 'Satuan harus diisi.',
            'status.required' => 'Status harus diisi.',
            'jumlah.required' => 'Jumlah harus diisi.'
        ]);

        Asset::find($this->asset_id)->update([
            'barang_id' => $this->barang_id,
            'merk' => $this->merk,
            'ruangan_id' => $this->ruangan_id,
            'unit_id' => $this->unit_id,
            'no_inventaris' => $this->no_inventaris,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'satuan' => $this->satuan,
            'status' => $this->status,
            'jumlah' => $this->jumlah
        ]);

        $this->resetForm();
        session()->flash('message', 'Asset berhasil diubah.');
        $this->dispatch('closeModal');
    }

    public function confirmDelete($id)
    {
        $this->asset_id = $id;
    }

    public function delete()
    {
        Asset::find($this->asset_id)->delete();
        session()->flash('message', 'Asset berhasil dihapus.');
    }

    public function detail($id)
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
    }


    public function resetForm()
    {
        $this->asset_id = null;
        $this->barang_id = null;
        $this->ruangan_id = null;
        $this->unit_id = null;
        $this->no_inventaris = null;
        $this->bulan = null;
        $this->tahun = null;
        $this->satuan = null;
        $this->status = null;
        $this->jumlah = null;
    }



}
