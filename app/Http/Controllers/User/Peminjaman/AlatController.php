<?php

namespace App\Http\Controllers\User\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        return view('user.peminjaman.alat.index');
    }
}
