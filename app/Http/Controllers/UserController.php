<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('user.user');
    }

    public function sendWhatsappMessage($userId)
    {
       // Ambil data user berdasarkan ID
       $user = User::find($userId);

       $decrypt = Crypt::decryptString($user->plain_password);
       // Periksa apakah user ditemukan
       if ($user) {
            $nama_lengkap = $user->nama_lengkap;
            $email        = $user->email;
            $no_hp        = $user->no_hp;

           // Membuat pesan WhatsApp
           $pesan = "*Pesan Pemberitahuan*\n";
           $pesan .= "Selamat Pagi, " . $nama_lengkap. "\n";
           $pesan .= "Informasi akun :\n";
           $pesan .= "Email: " . $email . "\n";
           $pesan .= "Password: " . $decrypt . "\n";

           // Menyusun URL WhatsApp
            $whatsapp = "https://api.whatsapp.com/send?phone=".$no_hp."&text=".urlencode($pesan);
            $link = $whatsapp;

           return redirect()->to($link);
       }

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
