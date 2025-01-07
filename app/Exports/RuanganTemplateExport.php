<?php

namespace App\Exports;

use App\Models\Ruangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RuanganTemplateExport implements WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Nama Ruangan',
        ];
    }
}
