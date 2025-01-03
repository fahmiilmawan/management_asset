<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ruangan::create([
            'nama_ruangan' => 'Ruangan IT'
        ]);
        Ruangan::create([
            'nama_ruangan' => 'Ruangan Finance'
        ]);
        Ruangan::create([
            'nama_ruangan' => 'Gudang'
        ]);
        Ruangan::create([
            'nama_ruangan' => 'Ruangan Produksi'
        ]);
        Ruangan::create([
            'nama_ruangan' => 'HRD'
        ]);
    }
}
