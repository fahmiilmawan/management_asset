<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangTemplateExport implements  WithHeadings
{
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
        ];
    }
}
