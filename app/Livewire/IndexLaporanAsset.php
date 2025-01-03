<?php

namespace App\Livewire;

use App\Models\Asset;
use Livewire\Component;
use Livewire\WithPagination;

class IndexLaporanAsset extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $periode = '';
    public $lokasi = '';

    // Debounce the search input to reduce the number of requests
    protected $updatesQueryString = ['search', 'periode', 'lokasi'];

    public function render()
    {
        $query = Asset::with('barang', 'ruangan', 'unit');

        // Search functionality
        if ($this->search) {
            $query->where(function($q) {
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

        // Filter by period
        if ($this->periode) {
            $query->where('tahun', $this->periode);
        }

        // Filter by location
        if ($this->lokasi) {
            $query->where('ruangan_id', $this->lokasi);
        }

        // Get unique locations for the filter
        $lokasis = Asset::with('ruangan')
            ->select('ruangan_id')
            ->distinct()
            ->get()
            ->map(function ($asset) {
                return [
                    'id' => $asset->ruangan_id,
                    'nama' => $asset->ruangan->nama_ruangan,
                ];
            });

        // Paginating the results
        return view('livewire.index-laporan-asset', [
            'assets' => $query->paginate(5),
            'periodes' => Asset::select('tahun')->distinct()->pluck('tahun'),
            'lokasis' => $lokasis,
        ]);
    }

    public function printPDF()
    {
        return redirect()->route('print.laporan-asset', [
            'search' => $this->search,
            'periode' => $this->periode,
            'lokasi' => $this->lokasi,
        ]);
    }

    public function exportExcel()
    {
        return redirect()->route('export.laporan-asset', [
            'search' => $this->search,
            'periode' => $this->periode,
            'lokasi' => $this->lokasi,
        ]);
    }
}
