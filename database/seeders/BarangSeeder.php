<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
            'kode_barang' => 'BRG001',
            'nama_barang' => 'Laptop Dell Inspiron 15'
        ]);
        
        Barang::create([
            'kode_barang' => 'BRG002',
            'nama_barang' => 'Mouse Logitech'
        ]);

        Barang::create([
            'kode_barang' => 'BRG003',
            'nama_barang' => 'Keyboard Mechanical Razer'
        ]);

        Barang::create([
            'kode_barang' => 'BRG004',
            'nama_barang' => 'Monitor Samsung 24"'
        ]);

        Barang::create([
            'kode_barang' => 'BRG005',
            'nama_barang' => 'Headphone Sony WH-1000XM5'
        ]);
    }
}
