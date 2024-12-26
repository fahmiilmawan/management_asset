<?php

namespace App\Livewire;

use App\Models\Asset;
use Livewire\Component;
use Livewire\WithPagination;

class IndexLaporanAsset extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $periode;


    public function render()
    {
        $query = Asset::with('barang', 'ruangan', 'unit');

        if ($this->search) {
            $query->where('no_inventaris', 'like', '%' . $this->search . '%')
                ->orWhereHas('barang', function ($q) {
                    $q->where('nama_barang', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('unit', function ($q) {
                    $q->where('nama_unit', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('ruangan', function ($q) {
                    $q->where('nama_ruangan', 'like', '%' . $this->search . '%');
                });
        }

        if ($this->periode) {
            $query->where('tahun', $this->periode);
        }

        return view('livewire.index-laporan-asset', [
            'assets' => $query->paginate(5),
            'periodes' => Asset::select('tahun')->distinct()->pluck('tahun'),
        ]);
    }
}
