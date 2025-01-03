<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPengaduanExport implements FromCollection, WithHeadings
{
    protected $search;
    protected $user;
    protected $asset;

    public function __construct($search = null, $user = null, $asset = null)
    {
        $this->search = $search;
        $this->user = $user;
        $this->asset = $asset;
    }

    public function collection()
    {
        $query = Pengaduan::with(['user', 'asset']);

        // Filter berdasarkan search
        if (!empty($this->search)) {
            $query->where('pengaduan', 'like', '%' . $this->search . '%');
        }

        // Filter berdasarkan user
        if (!empty($this->user)) {
            $query->where('user_id', $this->user);
        }

        // Filter berdasarkan asset
        if (!empty($this->asset)) {
            $query->where('asset_id', $this->asset);
        }

        // Ambil data dan transformasi untuk export
        return $query->get()->map(function ($item) {
            return [
                'pengaduan' => $item->pengaduan ?? 'N/A',
                'nama_lengkap' => $item->user->nama_lengkap ?? 'N/A',
                'nama_asset' => $item->asset->barang->nama_barang ?? 'N/A',
                'jumlah' => $item->jumlah ?? '0',
                'status' => $item->status ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Pengaduan',
            'Diajukan Oleh',
            'Asset',
            'Jumlah',
            'Status',
        ];
    }
}
