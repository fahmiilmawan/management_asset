<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Pengaduan;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaduan::create([
            'asset_id' => Asset::first()->id,
            'user_id' => Asset::first()->id,
            'pengaduan' => 'Kerusakan pada meja komputer',
            'jumlah' => 3,
            'status' => 'diproses',
            'bukti_fisik' => null,
            'deskripsi' => 'Meja komputer mengalami kerusakan serius pada kaki meja sehingga tidak dapat menopang beban. Kerusakan ini diduga akibat penggunaan jangka panjang tanpa perawatan rutin.',
            'tanggal_rusak' => '2024-12-01',
        ]);

        Pengaduan::create([
            'asset_id' => Asset::first()->id,
            'user_id' => Asset::first()->id,
            'pengaduan' => 'Kerusakan pada AC ruangan',
            'jumlah' => 1,
            'status' => 'sudah diperbaiki',
            'bukti_fisik' => 'ac_rusak.jpg',
            'deskripsi' => 'AC di ruang rapat mengalami gangguan pada sistem pendingin. Udara yang dihasilkan tidak dingin, dan terdapat suara berisik saat dioperasikan. Sudah diperbaiki oleh teknisi.',
            'tanggal_rusak' => '2024-11-15',
        ]);

        Pengaduan::create([
            'asset_id' => Asset::first()->id,
            'user_id' => Asset::first()->id,
            'pengaduan' => 'Lampu ruang kelas mati',
            'jumlah' => 5,
            'status' => 'diproses',
            'bukti_fisik' => null,
            'deskripsi' => 'Lampu di ruang kelas mati total. Hal ini membuat kegiatan belajar mengajar terganggu karena kondisi ruangan menjadi gelap. Perlu penggantian segera untuk semua lampu yang mati.',
            'tanggal_rusak' => '2024-12-05',
        ]);

        Pengaduan::create([
            'asset_id' => Asset::first()->id,
            'user_id' => Asset::first()->id,
            'pengaduan' => 'Kerusakan pada proyektor',
            'jumlah' => 1,
            'status' => 'sudah diperbaiki',
            'bukti_fisik' => 'proyektor_rusak.jpg',
            'deskripsi' => 'Proyektor mengalami kerusakan pada lampu dan kabel koneksi. Setelah diperiksa, kerusakan tersebut berhasil diperbaiki dengan mengganti lampu dan kabel baru.',
            'tanggal_rusak' => '2024-12-10',
        ]);

        Pengaduan::create([
            'asset_id' => Asset::first()->id,
            'user_id' => Asset::first()->id,
            'pengaduan' => 'Komputer laboratorium rusak',
            'jumlah' => 2,
            'status' => 'diproses',
            'bukti_fisik' => 'komputer_rusak.jpg',
            'deskripsi' => 'Dua unit komputer di laboratorium tidak bisa dinyalakan. Kerusakan diduga terjadi pada power supply dan motherboard. Hal ini mengganggu aktivitas praktikum siswa.',
            'tanggal_rusak' => '2024-12-20',
        ]);
    }
}
