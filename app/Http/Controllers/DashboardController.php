<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Pengadaan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); 

        // Total Asset - Tidak perlu difilter karena ini data umum
        $totalAssets = Asset::sum('jumlah');
        $assetsBaik = Asset::where('status', 'baik')->sum('jumlah');
        $assetsRusak = Asset::where('status', 'rusak')->count();
        $totalKeseluruhan = $assetsBaik + $assetsRusak;

        // Total Pengaduan untuk user yang login
        $totalPengaduan = Pengaduan::where('user_id', $userId)->sum('jumlah');
        $pengaduanDiproses = Pengaduan::where('user_id', $userId)->where('status', 'diproses')->count();
        $pengaduanDitolak = Pengaduan::where('user_id', $userId)->where('status', 'ditolak')->count();

        // Total Pengadaan untuk user yang login
        $totalPengadaan = Pengadaan::where('user_id', $userId)->count();
        $pengadaanDiajukan = Pengadaan::where('user_id', $userId)->where('status_pengadaan', 'diajukan')->count();
        $pengadaanDiproses = Pengadaan::where('user_id', $userId)->where('status_pengadaan', 'diproses')->count();
        $pengadaanDitolak = Pengadaan::where('user_id', $userId)->where('status_pengadaan', 'ditolak')->count();
        $pengadaanBarangTiba = Pengadaan::where('user_id', $userId)->where('status_pengadaan', 'barang tiba')->count();

        return view('dashboard', compact(
            'totalAssets',
            'assetsBaik',
            'assetsRusak',
            'totalKeseluruhan',
            'totalPengaduan',
            'pengaduanDiproses',
            'pengaduanDitolak',
            'totalPengadaan',
            'pengadaanDiproses',
            'pengadaanDiajukan',
            'pengadaanDitolak',
            'pengadaanBarangTiba'
        ));
    }
}
