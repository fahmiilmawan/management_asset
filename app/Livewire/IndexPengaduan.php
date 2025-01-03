<?php

namespace App\Livewire;

use App\Models\Asset;
use App\Models\Barang;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class IndexPengaduan extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $pengaduan_id, $asset_id, $user_id, $pengaduan, $jumlah, $status, $bukti_fisik, $deskripsi, $tanggal_rusak, $search;



    public function render()
    {


        $pengaduans = Pengaduan::with('user', 'asset')->when(!Auth::user()->isAdmin(),function ($query){
            return $query->where('user_id', Auth::user()->id);
        })->paginate(5);

        if (empty($this->search)) {
            $pengaduans = Pengaduan::with('user', 'asset')->paginate(5);
        } elseif (trim($this->search) == '') {
            $pengaduans = Pengaduan::with('user', 'asset')->paginate(5);
        } else {
            $pengaduans = Pengaduan::with('user', 'asset')
                ->where('pengaduan', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('asset.barang', function ($q) {
                    $q->where('nama_barang', 'like', '%' . $this->search . '%')
                        ->orWhere('tanggal_rusak', 'like', '%' . $this->search . '%');
                });
    };

    $pengaduans = Pengaduan::Orderby('id', 'desc')->paginate(5);


        return view('livewire.index-pengaduan',[
            'pengaduans' => $pengaduans,
            'assets' => Asset::with('barang', 'ruangan', 'unit')->get(),
            'barangs' => Barang::all(),
        ]);
    }

    public function updateStatus($id, $status)
{
    $pengaduan = Pengaduan::findOrFail($id);

    $pengaduan->update([
        'status' => $status
    ]);

    session()->flash('message', 'Status pengaduan berhasil diubah menjadi ' . $status . '.');
}

    public function store()
    {
        $this->validate([
            'asset_id' => 'required',
            'pengaduan' => 'required',
            'jumlah' => 'required',
            'deskripsi' => 'required',
            'tanggal_rusak' => 'required',
        ],
        [
            'asset_id.required' => 'Asset harus diisi.',
            'pengaduan.required' => 'Pengaduan harus diisi.',
            'jumlah.required' => 'Jumlah harus diisi.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'tanggal_rusak.required' => 'Tanggal rusak harus diisi.',
        ]);

        $bukti_fisik = $this->uploadBuktiFisik();

        Pengaduan::create([
            'asset_id' => $this->asset_id,
            'user_id' => Auth::user()->id,
            'pengaduan' => $this->pengaduan,
            'jumlah' => $this->jumlah,
            'status' => 'diajukan',
            'bukti_fisik' => $bukti_fisik,
            'deskripsi' => $this->deskripsi,
            'tanggal_rusak' => $this->tanggal_rusak,
        ]);

        session()->flash('message', 'Pengaduan berhasil ditambahkan.');

        $this->resetForm();
        $this->dispatch('closeModal');
    }

    private function uploadBuktiFisik()
    {
        if ($this->bukti_fisik) {
            return $this->bukti_fisik->storeAs('bukti-fisik', $this->bukti_fisik->getClientOriginalName(),'public');
        }
        return null;
    }

    public function detail($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $this->pengaduan_id = $pengaduan->id;
        $this->asset_id = $pengaduan->asset_id;
        $this->user_id = $pengaduan->user_id;
        $this->pengaduan = $pengaduan->pengaduan;
        $this->jumlah = $pengaduan->jumlah;
        $this->status = $pengaduan->status;
        $this->bukti_fisik = $pengaduan->bukti_fisik;
        $this->deskripsi = $pengaduan->deskripsi;
        $this->tanggal_rusak = $pengaduan->tanggal_rusak;

    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $this->pengaduan_id = $pengaduan->id;
        $this->asset_id = $pengaduan->asset_id;
        $this->user_id = $pengaduan->user_id;
        $this->pengaduan = $pengaduan->pengaduan;
        $this->jumlah = $pengaduan->jumlah;
        $this->status = $pengaduan->status;
        $this->bukti_fisik = $pengaduan->bukti_fisik;
        $this->deskripsi = $pengaduan->deskripsi;
        $this->tanggal_rusak = $pengaduan->tanggal_rusak;
    }

    public function update()
    {

        $this->validate([
            'asset_id' => 'required',
            'pengaduan' => 'required',
            'jumlah' => 'required',
            'deskripsi' => 'required',
            'tanggal_rusak' => 'required',
        ],
        [
            'asset_id.required' => 'Asset harus diisi.',
            'pengaduan.required' => 'Pengaduan harus diisi.',
            'jumlah.required' => 'Jumlah harus diisi.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'tanggal_rusak.required' => 'Tanggal rusak harus diisi.',
        ]);

        $filePath = $this->uploadBuktiFisik();
        Pengaduan::find($this->pengaduan_id)->update([
            'asset_id' => $this->asset_id,
            'user_id' => $this->user_id,
            'pengaduan' => $this->pengaduan,
            'jumlah' => $this->jumlah,
            'status' => $this->status,
            'bukti_fisik' => $filePath,
            'deskripsi' => $this->deskripsi,
            'tanggal_rusak' => $this->tanggal_rusak,
        ]);

        $this->resetForm();

        session()->flash('message', 'Pengaduan berhasil diperbarui.');
        $this->dispatch('closeModal');
    }

    public function confirmDelete($id)
    {
        $this->pengaduan_id = $id;

    }

    public function delete()
    {
        Pengaduan::find($this->pengaduan_id)->delete();

        session()->flash('message', 'Pengaduan berhasil dihapus.');
    }


    public function resetForm()
    {
        $this->pengaduan_id = null;
        $this->asset_id = null;
        $this->user_id = null;
        $this->pengaduan = '';
        $this->jumlah = '';
        $this->status = '';
        $this->bukti_fisik = '';
        $this->deskripsi = '';
        $this->tanggal_rusak = '';
    }
}
