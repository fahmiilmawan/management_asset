<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'barang_id',
        'merk',
        'ruangan_id',
        'unit_id',
        'no_inventaris',
        'bulan',
        'tahun',
        'satuan',
        'status',
        'jumlah',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
