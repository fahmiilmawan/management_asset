<?php

namespace App\Livewire;

use App\Models\Pengadaan;
use Livewire\Component;
use Livewire\WithPagination;

class IndexLaporanPengadaan extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $start_date, $end_date;

    public function render()
    {
        $query = Pengadaan::with('user', 'ruangan');

        // Search functionality
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_barang_pengadaan', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('ruangan', function ($q) {
                        $q->where('nama_ruangan', 'like', '%' . $this->search . '%');
                    });
            });
        }
    

        // Filter by date range
        if($this->start_date && $this->end_date){
            $query->whereBetween('tanggal_pengadaan', [$this->start_date, $this->end_date]);
        }

        return view('livewire.index-laporan-pengadaan', [
            'pengadaans' => $query->paginate(5),
        ]);
    }

    public function printPDF()
    {
        return redirect()->route('print.laporan-pengadaan', [
            'search' => $this->search,
            'ruangan' => $this->ruangan,
            'user' => $this->user,
        ]);
    }

    public function exportExcel()
    {
        return redirect()->route('export.laporan-pengadaan', [
            'search' => $this->search,
            'ruangan' => $this->ruangan,
            'user' => $this->user,
        ]);
    }
}
