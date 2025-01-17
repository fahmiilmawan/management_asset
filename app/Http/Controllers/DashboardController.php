<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Barang;
use App\Models\Pengadaan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total Asset
        $totalAssets = Asset::select('jumlah')->sum('jumlah');
        $assetsBaik = Asset::where('status', 'baik')->sum('jumlah');


        $assetsRusak = Asset::where('status', 'rusak')->count();

        // Total Pengaduan
        $totalPengaduan = Pengaduan::where('status_barang','rusak')->sum('jumlah');

        $totalKeseluruhan = $assetsBaik + $totalPengaduan;
        $pengaduanDiproses = Pengaduan::where('status', 'diproses')->count();
        $pengaduanDitolak = Pengaduan::where('status', 'ditolak')->count();

        // Total Pengadaan
        $totalPengadaan = Pengadaan::count();
        $pengadaanDiproses = Pengadaan::where('status_pengadaan', 'diproses')->count();
        $pengadaanDiajukan = Pengadaan::where('status_pengadaan', 'diajukan')->count();
        $pengadaanDitolak = Pengadaan::where('status_pengadaan', 'ditolak')->count();
        $pengadaanBarangTiba = Pengadaan::where('status_pengadaan', 'barang tiba')->count();

        return view('dashboard', compact(
            'totalAssets',
            'assetsBaik',
            'assetsRusak',
            'totalPengaduan',
            'pengaduanDiproses',
            'pengaduanDitolak',
            'totalPengadaan',
            'pengadaanDiproses',
            'pengadaanDiajukan',
            'pengadaanDitolak',
            'pengadaanBarangTiba',
            'totalKeseluruhan'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
