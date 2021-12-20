<?php

namespace App\Http\Controllers\Admin;

use App\Alat;
use App\Borrow;
use App\Http\Controllers\Controller;
use App\Ruangan;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $alat = Alat::count();
        $ruangan = Ruangan::count();
        $alat_dipinjam = Alat::with(['borrow' => function ($query) {
            $query->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->whereDate('begin_date', '<=', Carbon::now()->format('Y-m-d'));
        }])->count();
        $ruangan_dipinjam = Ruangan::with(['borrow' => function ($query) {
            $query->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->whereDate('begin_date', '<=', Carbon::now()->format('Y-m-d'));
        }])->count();
        $peminjaman = Borrow::count();
        $peminjaman_diterima = Borrow::where('status', 1)->count();
        $pengguna = User::where('role', 'user')->count();
        return view('admin.dashboard', compact('alat', 'ruangan', 'alat_dipinjam', 'ruangan_dipinjam', 'peminjaman', 'peminjaman_diterima', 'pengguna'));
    }
}
