<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanQRController extends Controller
{
    public function index()
    {
        return view('scanqr.index');
    }


}
