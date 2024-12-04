<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class IndexUser extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $user_id, $nama_lengkap, $email, $password, $role, $unit_id, $no_hp, $pesan,$whatsapp;
    public $isModalOpen = false;

    protected function rules()
    {
        $rules = [
            'unit_id' => 'required|exists:units,id',
            'nama_lengkap' => 'required|string|max:255',
            'role' => 'required|in:administrator,admin_umum,staff_unit',
            'no_hp' => 'nullable|regex:/^\+?[0-9]{10,15}$/', // Validasi nomor telepon (opsional, bisa kosong)
        ];

        if ($this->user_id) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->user_id;
            $rules['password'] = 'nullable|min:6';
        } else {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:6';
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.index-user', [
            'users' => User::with('unit')->paginate(5),
            'units' => Unit::all(),
        ]);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->isModalOpen = false;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->unit_id = $user->unit_id;
        $this->nama_lengkap = $user->nama_lengkap;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->no_hp = $user->no_hp;
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        if ($this->user_id) {
            $user = User::findOrFail($this->user_id);
            $user->update([
                'unit_id' => $this->unit_id,
                'nama_lengkap' => $this->nama_lengkap,
                'email' => $this->email,
                'role' => $this->role,
                'no_hp' => $this->no_hp,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
            ]);
            session()->flash('message', 'User berhasil diperbarui.');
        } else {
            User::create([
                'unit_id' => $this->unit_id,
                'nama_lengkap' => $this->nama_lengkap,
                'email' => $this->email,
                'role' => $this->role,
                'no_hp' => $this->no_hp,
                'password' =>$this->password,
            ]);
            session()->flash('message', 'User berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            session()->flash('message', 'User tidak ditemukan.');
            return;
        }

        $user->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }

    private function resetForm()
    {
        $this->user_id = null;
        $this->unit_id = '';
        $this->nama_lengkap = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->no_hp = '';
    }


}
