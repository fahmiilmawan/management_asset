<?php

namespace App\Livewire;

use App\Models\Unit;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class IndexUser extends Component
{
    use WithPagination;

    public $user_id,$nama_lengkap, $unit_id, $email, $password, $role;

    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    protected $rules = [
        'nama_lengkap' => 'required',
        'unit_id' => 'required',
        'email' => 'required',
        'password' => 'required',
        'role' => 'required',
    ];

    protected $messages = [
        'nama_lengkap.required' => 'Nama Lengkap harus diisi.',
        'unit_id.required' => 'Unit harus dipilih.',
        'email.required' => 'Email harus diisi.',
        'password.required' => 'Password harus diisi.',
        'role.required' => 'Role harus dipilih.',
    ];

    public function render()
    {
        return view('livewire.index-user',[
            'users' => User::with('unit')->paginate(5),
            'units' => Unit::all(),
        ]);

    }

    public function store()
    {
        $this->validate();

        User::create([
            'nama_lengkap' => $this->nama_lengkap,
            'unit_id' => $this->unit_id,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role
        ]);

        session()->flash('message', 'User berhasil ditambahkan.');

        $this->resetForm();
        $this->isModalOpen = false;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->nama_lengkap = $user->nama_lengkap;
        $this->unit_id = $user->unit_id;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->role = $user->role;
        $this->isModalOpen = true;
    }

    public function update()
    {
        $this->validate();

        User::find($this->user_id)->update([
            'nama_lengkap' => $this->nama_lengkap,
            'unit_id' => $this->unit_id,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role
        ]);

        session()->flash('message', 'User berhasil diperbarui.');

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->user_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        $user = User::findOrFail($this->user_id);
        $user->delete();

        session()->flash('message', 'User berhasil dihapus.');
        $this->isDeleteModalOpen = false;
    }

    public function isModalOpen()
    {
        $this->isModalOpen = true;
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }
    public function closeModal()
    {
        $this->isModalOpen = false;
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
