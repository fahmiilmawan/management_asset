<?php

namespace App\Livewire;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class IndexUser extends Component
{
    use WithPagination;

    public $user_id,$nama_lengkap, $unit_id, $email, $password, $role, $no_hp;

    public function render()
    {
        return view('livewire.index-user',[
            'users' => User::with('unit')->paginate(5),
            'units' => Unit::all(),
        ]);

    }

    public function store()
    {
        $this->validate([
            'unit_id' => 'required',
            'nama_lengkap' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'role' => 'required',
            'no_hp' => 'required'
        ],[
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'unit_id.required' => 'Unit tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah ada',
            'password.required' => 'Password tidak boleh kosong',
            'role.required' => 'Role tidak boleh kosong',
            'no_hp.required' => 'No HP tidak boleh kosong',
        ]);

        User::create([
            'unit_id' => $this->unit_id,
            'nama_lengkap' => $this->nama_lengkap,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'plain_password' =>Crypt::encryptString($this->password),
            'role' => $this->role,
            'no_hp' => $this->no_hp
        ]);

        $this->resetForm();

        session()->flash('message', 'User berhasil ditambahkan.');
        $this->dispatch('closeModal');

    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->unit_id = $user->unit_id;
        $this->nama_lengkap = $user->nama_lengkap;
        $this->email = $user->email;
        $this->password = null;
        $this->role = $user->role;
        $this->no_hp = $user->no_hp;
    }

    public function update()
    {
        $this->validate([
            'unit_id' => 'required',
            'nama_lengkap' => 'required',
            'email' => 'required|unique:users,email,'.$this->user_id,
            'password' => 'required',
            'role' => 'required',
            'no_hp' => 'required'
        ],[
            'unit_id.required' => 'Unit tidak boleh kosong',
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah ada',
            'password.required' => 'Password tidak boleh kosong',
            'role.required' => 'Role tidak boleh kosong',
            'no_hp.required' => 'No HP tidak boleh kosong',
        ]);

        $user = User::findOrFail($this->user_id);
        $user->update([
            'unit_id' => $this->unit_id,
            'nama_lengkap' => $this->nama_lengkap,
            'email' => $this->email,
            'plain_password' => Crypt::encryptString($this->password),
            'password' => Hash::make($this->password),
            'plain_password' => $this->password,
            'role' => $this->role,
            'no_hp' => $this->no_hp
        ]);

        $this->resetForm();

        session()->flash('message', 'User berhasil diubah.');
        $this->dispatch('closeModal');
    }

    public function confirmDelete($id)
    {
        $this->user_id = $id;

    }

    public function delete()
    {
        $user = User::findOrFail($this->user_id);
        $user->delete();

        session()->flash('message', 'User berhasil dihapus.');
    }



    public function resetForm()
    {
        $this->user_id = null;
        $this->unit_id = null;
        $this->email = '';
        $this->password = '';
        $this->role = '';
    }
}
