<?php

namespace App\Livewire;

use App\Exports\LaporanPengaduanExport;
use App\Models\Pengaduan;
use Livewire\Component;
use Livewire\WithPagination;

class IndexLaporanPengaduan extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $start_date, $end_date;
    protected $updatesQueryString = ['search', 'asset', 'user'];

    public function render()
    {
        $query = Pengaduan::with('user', 'asset');

        // Search functionality
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('pengaduan', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('asset.barang', function ($q) {
                        $q->where('nama_barang', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filter by range date
        if ($this->start_date && $this->end_date) {
            $query->whereBetween('tanggal_rusak', [$this->start_date, $this->end_date]);
        }


        return view('livewire.index-laporan-pengaduan', [
            'pengaduans' => $query->paginate(5),
        ]);
    }
    public function printPDF()
    {
        return redirect()->route('print.laporan-pengaduan', [
            'search' => $this->search,
            'asset' => $this->asset,
            'user' => $this->user,
        ]);
    }
    public function exportExcel()
    {
        return redirect()->route('export.laporan-pengaduan', [
            'search' => $this->search,
            'asset' => $this->asset,
            'user' => $this->user,
        ]);
    }
}
