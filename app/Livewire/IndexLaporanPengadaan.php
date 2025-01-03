<?php

namespace App\Livewire;

use App\Models\Pengadaan;
use Livewire\Component;
use Livewire\WithPagination;

class IndexLaporanPengadaan extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '', $ruangan = '', $user = '';
    protected $updatesQueryString = ['search', 'ruangan', 'user'];

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

        // Filter by room and user
        if ($this->ruangan) {
            $query->where('ruangan_id', $this->ruangan);
        }
        if ($this->user) {
            $query->where('user_id', $this->user);
        }

        // Get unique rooms for the filter
        $ruangans = Pengadaan::with('ruangan')
            ->select('ruangan_id')
            ->distinct()
            ->get()
            ->map(function ($pengadaan) {
                return [
                    'ruangan_id' => $pengadaan->ruangan_id,
                    'nama_ruangan' => $pengadaan->ruangan->nama_ruangan,
                ];
            });

        // Get unique users for the filter
        $users = Pengadaan::with('user')
            ->select('user_id')
            ->distinct()
            ->get()
            ->map(function ($pengadaan) {
                return [
                    'user_id' => $pengadaan->user_id,
                    'nama_lengkap' => $pengadaan->user->nama_lengkap,
                ];
            });

        return view('livewire.index-laporan-pengadaan', [
            'pengadaans' => $query->paginate(5),
            'ruangans' => $ruangans,
            'users' => $users,
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
