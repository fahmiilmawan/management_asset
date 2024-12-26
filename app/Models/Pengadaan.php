<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_barang_pengadaan',
        'ruangan_id',
        'jumlah_pengadaan',
        'satuan_pengadaan',
        'harga_satuan',
        'total_harga',
        'tahun_pengadaan',
        'tanggal_pengadaan',
        'status_pengadaan',
        'deskripsi'
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
