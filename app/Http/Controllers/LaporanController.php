<?php

namespace App\Http\Controllers;

use App\Exports\LaporanAssetExport;
use App\Exports\LaporanPengadaanExport;
use App\Exports\LaporanPengaduanExport;
use App\Helper\QRCode;
use App\Models\Asset;
use App\Models\Pengadaan;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexLaporanAsset()
    {
        return view('laporan.laporan-asset');
    }

    public function generatePrintPDFAsset(Request $request)
    {
        $search = $request->input('search');
        $periode = $request->input('periode');
        $lokasi = $request->input('lokasi');

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

        $pdf = Pdf::loadView('laporan.print-laporan-asset', compact('assets'));

        return $pdf->download('laporan_asset.pdf');
    }

    public function exportExcelAsset(Request $request)
    {
        $search = $request->input('search');


        return Excel::download(new LaporanAssetExport($search), 'laporan-asset.xlsx');
    }

    public function indexLaporanPengadaan()
    {
        return view('laporan.laporan-pengadaan');
    }

    public function generatePrintPDFPengadaan(Request $request)
    {
        $search = $request->input('search');

        $query = Pengadaan::with('ruangan', 'user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang_pengadaan', 'like', '%' . $search . '%')
                    ->orWhereHas('ruangan', function ($q) use ($search) {
                        $q->where('nama_ruangan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', '%' . $search . '%');
                    });
            });
        }

        $pengadaans = $query->get();

        $pdf = Pdf::loadView('laporan.print-laporan-pengadaan', compact('pengadaans'));

        return $pdf->download('laporan_pengadaan.pdf');
    }

    public function exportExcelPengadaan(Request $request)
    {
        $search = $request->input('search');


        return Excel::download(new LaporanPengadaanExport($search), 'laporan-pengadaan.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function indexLaporanPengaduan()
    {
        return view('laporan.laporan-pengaduan');
    }

    public function generatePrintPDFPengaduan(Request $request)
    {
        $search = $request->input('search');

        $query = Pengaduan::with('asset', 'user');

        // Search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('pengaduan', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('asset.barang', function ($q) use ($search) {
                        $q->where('nama_barang', 'like', '%' . $search . '%');
                    });
            });
        }


        $pengaduans = $query->get();


        $pdf = Pdf::loadView('laporan.print-laporan-pengaduan', compact('pengaduans'));

        return $pdf->download('laporan_pengaduan.pdf');
    }

    public function exportExcelPengaduan(Request $request)
    {
        $search = $request->input('search');

        return Excel::download(new LaporanPengaduanExport($search), 'laporan-pengaduan.xlsx');
    }

}
