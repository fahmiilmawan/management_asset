<?php
// app/Exports/BarangsExport.php
namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BarangsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $search;
    protected $filter;

    public function __construct($search = '', $filter = '')
    {
        $this->search = $search;
        $this->filter = $filter;
    }

    public function collection()
    {
        return Barang::where('nama_barang', 'like', '%' . $this->search . '%')
            ->when($this->filter, function ($query) {
                $query->where('kode_barang', $this->filter);
            })
            ->get(['id', 'kode_barang', 'nama_barang', 'created_at']);
    }

    public function headings(): array
    {
        return ["ID", "Kode Barang", "Nama Barang", "Tanggal Ditambahkan"];
    }
}
