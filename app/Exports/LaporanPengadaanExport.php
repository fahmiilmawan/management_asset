<?php

namespace App\Exports;

use App\Models\Pengadaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPengadaanExport implements FromCollection, WithHeadings
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;

    }

    public function collection()
    {
        $query = Pengadaan::with(['user', 'ruangan']);
        // Filter berdasarkan search
        if (!empty($this->search)) {
            $query->where('nama_barang_pengadaan', 'like', '%' . $this->search . '%');
        }


        // Ambil data dan transformasi untuk export
        return $query->get()->map(function ($item) {
            return [
                'nama_barang_pengadaan' => $item->nama_barang_pengadaan ?? 'N/A',
                'nama_lengkap'   => $item->user->nama_lengkap ?? 'N/A',
                'nama_ruangan'  => $item->ruangan->nama_ruangan ?? 'N/A',
                'harga_satuan'        => $item->harga_satuan ?? '0',
                'jumlah'        => $item->jumlah_pengadaan ?? '0',
                'total_harga'       => $item->total_harga ?? 'N/A',
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Nama Barang',
            'Diajukan Oleh',
            'Untuk Ruangan',
            'Harga Satuan',
            'Jumlah',
            'Total Harga',
        ];
    }
}
