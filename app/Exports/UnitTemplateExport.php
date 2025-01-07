<?php

namespace App\Exports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UnitTemplateExport implements WithHeadings
{

    public function headings(): array
    {
        return [
            'Nama Unit',
        ];
    }
}
