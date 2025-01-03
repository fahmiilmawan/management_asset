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
    public $search = '', $asset = '', $user = '';
    protected $updatesQueryString = ['search', 'asset', 'user'];

    public function render()
    {
        $query = Pengaduan::with('user', 'asset');

        // Search functionality
        if ($this->search) {
            $query->where(function($q) {
                $q->where('pengaduan', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('asset.barang', function ($q) {
                        $q->where('nama_barang', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filter by asset and user
        if ($this->asset) {
            $query->where('asset_id', $this->asset);
        }
        if ($this->user) {
            $query->where('user_id', $this->user);
        }

        // Get unique assets for the filter
        $assets = Pengaduan::with('asset')
            ->select('asset_id')
            ->distinct()
            ->get()
            ->map(function ($pengaduan) {
                return [
                    'asset_id' => $pengaduan->asset_id,
                    'nama_asset' => $pengaduan->asset->barang->nama_barang,
                ];
            });

        // Get unique users for the filter
        $users = Pengaduan::with('user')
            ->select('user_id')
            ->distinct()
            ->get()
            ->map(function ($pengaduan) {
                return [
                    'user_id' => $pengaduan->user_id,
                    'nama_lengkap' => $pengaduan->user->nama_lengkap,
                ];
            });

        return view('livewire.index-laporan-pengaduan', [
            'pengaduans' => $query->paginate(5),
            'assets' => $assets,
            'users' => $users,
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
