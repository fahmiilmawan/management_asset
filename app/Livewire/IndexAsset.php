<?php

namespace App\Livewire;

use App\Helper\QRCode;
use App\Models\Asset;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Unit;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Livewire\Component;
use Livewire\WithPagination;

class IndexAsset extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $asset_id, $barang_id, $ruangan_id, $unit_id, $no_inventaris, $bulan, $tahun, $satuan, $status, $jumlah;

    public $isModalOpen = false;
    public $isDetailModalOpen = false;
    public $isDeleteModalOpen = false;

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

    protected $rules = [
        'barang_id' => 'required',
        'ruangan_id' => 'required',
        'unit_id' => 'required',
        'bulan' => 'required',
        'tahun' => 'required',
        'satuan' => 'required',
        'status' => 'required',
        'jumlah' => 'required',
    ];

    protected $messages = [
        'barang_id.required' => 'Asset harus diisi',
        'ruangan_id.required' => 'Ruangan harus diisi',
        'unit_id.required' => 'Unit harus diisi',
        'bulan.required' => 'Bulan harus diisi',
        'tahun.required' => 'Tahun harus diisi',
        'satuan.required' => 'Satuan harus diisi',
        'status.required' => 'Status harus diisi',
        'jumlah.required' => 'Jumlah harus diisi',
    ];

    public function render()
    {
        return view('livewire.index-asset',[
            'assets' => Asset::with('barang', 'ruangan', 'unit')->paginate(5),
            'barangs' => Barang::all(),
            'ruangans' => Ruangan::all(),
            'units' => Unit::all(),
            'bulanRomawi' => $this->bulanRomawi
        ]);
    }

    public function store(){
        $this->validate();

         Asset::create([
            'barang_id' => $this->barang_id,
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
        $this->isModalOpen = false;
        session()->flash('message', 'Asset berhasil ditambahkan.');
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

    public function update()
    {
        $this->validate();
        Asset::find($this->asset_id)->update([
            'barang_id' => $this->barang_id,
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
        $this->isModalOpen = false;
        session()->flash('message', 'Asset berhasil diubah.');
    }

    public function confirmDelete($id)
    {
        $this->asset_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        Asset::find($this->asset_id)->delete();
        $this->isDeleteModalOpen = false;
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
        $this->isDetailModalOpen = true;
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
