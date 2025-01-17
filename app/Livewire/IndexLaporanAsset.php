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
    public $start_date, $end_date;
    // Debounce the search input to reduce the number of requests
    protected $updatesQueryString = ['search', 'periode', 'lokasi'];

    public function render()
    {
        $query = Asset::with('barang', 'ruangan', 'unit');

        // Search functionality
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

        //Filter by date range
        if ($this->start_date && $this->end_date) {
            $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        // Paginating the results
        return view('livewire.index-laporan-asset', [
            'assets' => $query->paginate(5),
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
