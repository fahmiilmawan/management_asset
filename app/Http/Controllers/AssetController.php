<?php

namespace App\Http\Controllers;

use App\Helper\QRCode;
use App\Models\Asset;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('asset.asset');
    }

    public function detailAsset(Request $request)
    {
        $no_inventaris = $request->no_inventaris;
        $getInventaris = Asset::where('no_inventaris', $no_inventaris)->first();
        return view('asset.detail-asset', compact('getInventaris'));
    }


    public function generatePrintQRCode(Request $request)
    {
        $search = $request->input('search');


        $query = Asset::with('barang', 'ruangan', 'unit');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_inventaris', 'like', '%' . $search . '%')
                  ->orWhereHas('barang', function ($q) use ($search) {
                      $q->where('nama_barang', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('unit', function ($q) use ($search) {
                      $q->where('nama_unit', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('ruangan', function ($q) use ($search) {
                      $q->where('nama_ruangan', 'like', '%' . $search . '%');
                  });
            });
        }

        $assets = $query->get();

        // Generate QR Code for each asset
        foreach ($assets as $asset) {
            $QRCode = new QRCode($asset->no_inventaris); // Correcting the usage
            $asset->qr_code = $QRCode->generate(); // Assign the QR code
        }

        $pdf = Pdf::loadView('laporan.print-qr-code', compact('assets'));

        return $pdf->download('laporan_qr_code.pdf');

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
