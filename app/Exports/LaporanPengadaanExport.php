<?php

namespace App\Exports;

use App\Models\Pengadaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPengadaanExport implements FromCollection, WithHeadings
{
    protected $search;
    protected $user;
    protected $ruangan;

    public function __construct($search = null, $user = null, $ruangan = null)
    {
        $this->search = $search;
        $this->user = $user;
        $this->ruangan = $ruangan;
    }

    public function collection()
    {
        $query = Pengadaan::with(['user', 'ruangan']);
        // Filter berdasarkan search
        if (!empty($this->search)) {
            $query->where('nama_barang_pengadaan', 'like', '%' . $this->search . '%');
        }

        // Filter berdasarkan user
        if (!empty($this->user)) {
            $query->where('user_id', $this->user);
        }

        // Filter berdasarkan ruangan
        if (!empty($this->ruangan)) {
            $query->where('ruangan_id', $this->ruangan);
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
