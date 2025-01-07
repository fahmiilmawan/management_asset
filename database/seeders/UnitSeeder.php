<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'id'=>1,
            'nama_unit' =>'IT',
        ]);
        Unit::create([
            'id'=>2,
            'nama_unit' =>'IT 2',
        ]);
        Unit::create([
            'id'=>3,
            'nama_unit' =>'IT 3',
        ]);
        Unit::create([
            'id'=>4,
            'nama_unit' =>'IT 4',
        ]);
    }
}
