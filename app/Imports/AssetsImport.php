<?php

namespace App\Imports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ToModel;

class AssetsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $noUrut = Asset::max('no_urut') ?? 0;
        $newNoUrut = $noUrut + 1;

        return new Asset([
            'no_urut' => $newNoUrut,
            'no_inventaris' => $row[0],
            'bulan' => $row[1],
            'tahun' => $row[2],
            'barang_id' => $row[3],
            'merk' => $row[4],
            'jumlah' => $row[5],
            'status' => $row[6],
            'ruangan_id' => $row[7],
            'unit_id' => $row[8]
        ]);
    }
}
