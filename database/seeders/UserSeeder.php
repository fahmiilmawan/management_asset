<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_lengkap' =>'administrator',
            'unit_id' =>1,
            'email'=>'administrator@gmail.com',
            'password'=>Hash::make('administrator'),
            'plain_password'=>Crypt::encrypt('administrator'),
            'role'=>'administrator',

        ]);
        User::create([
            'nama_lengkap' =>'Admin Umum',
            'unit_id' =>1,
            'email'=>'admin_umum@gmail.com',
            'password'=>Hash::make('adminumum'),
            'plain_password'=>Crypt::encrypt('adminumum'),
            'role'=>'admin_umum',

        ]);
        User::create([
            'nama_lengkap' =>'Staff Unit',
            'unit_id' =>1,
            'email'=>'staff_unit@gmail.com',
            'password'=>Hash::make('staff_unit'),
            'plain_password'=>Crypt::encrypt('staffunit'),
            'role'=>'staff_unit',

        ]);
    }
}
