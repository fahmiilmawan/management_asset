<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    protected $fillable = [
        'nama_ruangan'
    ];

    public function assets() :HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
