<?php
namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class SettingProfile extends Component
{
    public $nama_lengkap, $email, $no_hp, $password, $password_confirmation;

    public function mount()
    {
        $user = Auth::user();

        $this->nama_lengkap = $user->nama_lengkap;
        $this->email = $user->email;
        $this->no_hp = $user->no_hp;
    }

    public function updateProfile()
    {
        $this->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->nama_lengkap = $this->nama_lengkap;
        $user->email = $this->email;
        $user->no_hp = $this->no_hp;
        $user->password = Hash::make($this->password);
        $user->plain_password = Crypt::encryptString($this->password);

        $user->save();  
        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.setting-profile');
    }
}
