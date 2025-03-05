<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanAssetExport implements FromCollection, WithHeadings
{
    protected $search;


    // Constructor untuk menerima parameter filter
    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = Asset::with(['barang', 'unit', 'ruangan']);
        // Filter berdasarkan search
        if (!empty($this->search)) {
            $query->whereHas('barang', function ($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%');
            });
        }

        // Ambil data dan transformasi untuk export
        return $query->get()->map(function ($item) {
            return [
                'no_inventaris' => $item->no_inventaris,
                'nama_barang'   => $item->barang->nama_barang ?? 'N/A',
                'nama_unit'     => $item->unit->nama_unit ?? 'N/A',
                'nama_ruangan'  => $item->ruangan->nama_ruangan ?? 'N/A',
                'jumlah'        => $item->jumlah,
                'periode'       => $item->tahun,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No Inventaris',
            'Nama Barang',
            'Nama Unit',
            'Nama Ruangan',
            'Jumlah',
            'Periode',
        ];
    }
}
