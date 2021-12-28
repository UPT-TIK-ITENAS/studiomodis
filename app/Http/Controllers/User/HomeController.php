<?php

namespace App\Http\Controllers\User;

use App\Borrow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $peminjaman_ruangan = Borrow::with(['ruangan', 'alat'])->whereHas('ruangan')->where('user_id', auth()->user()->id);
        $peminjaman_alat = Borrow::with(['ruangan', 'alat'])->whereDoesntHave('ruangan')->whereHas('alat')->where('user_id', auth()->user()->id);
        $peminjaman_ruangan_m = $peminjaman_ruangan->where('status', 0)->count();
        $peminjaman_ruangan_s = $peminjaman_ruangan->where('status', 1)->count();
        $peminjaman_ruangan_t = $peminjaman_ruangan->where('status', 2)->count();
        $peminjaman_alat_m = $peminjaman_alat->where('status', 0)->count();
        $peminjaman_alat_s = $peminjaman_alat->where('status', 1)->count();
        $peminjaman_alat_t = $peminjaman_alat->where('status', 2)->count();
        return view('user.home', compact('peminjaman_ruangan_m', 'peminjaman_ruangan_s', 'peminjaman_ruangan_t', 'peminjaman_alat_m', 'peminjaman_alat_s', 'peminjaman_alat_t'));
    }
}
