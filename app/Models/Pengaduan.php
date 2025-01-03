<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'asset_id','user_id','pengaduan','jumlah','status','bukti_fisik','deskripsi','tanggal_rusak'
    ];

    public function asset()
{
    return $this->belongsTo(Asset::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
public function ruangan()
{
    return $this->belongsTo(Ruangan::class);
}

}
