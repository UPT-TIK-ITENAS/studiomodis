<?php

namespace App\Http\Controllers\Admin;

use App\Alat;
use App\Borrow;
use App\Http\Controllers\Controller;
use App\Ruangan;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $alat = Alat::count();
        $ruangan = Ruangan::count();
        $alat_dipinjam = Borrow::with(['alat'])->whereDoesntHave('ruangan')->whereHas('alat')->whereDate('created_at', '=', Carbon::today())->count();
        $ruangan_dipinjam = Borrow::with(['ruangan'])->whereHas('ruangan')->whereDate('created_at', '=', Carbon::today())->count();
        $peminjaman = Borrow::count();
        $peminjaman_diterima = Borrow::where('status', 1)->count();
        $pengguna = User::where('role', 'user')->count();
        $year = DB::table('borrows')->select(DB::raw("DISTINCT(DATE_FORMAT(created_at, '%Y')) AS tahun"))->get();
        return view('admin.dashboard', compact('alat', 'ruangan', 'alat_dipinjam', 'ruangan_dipinjam', 'peminjaman', 'peminjaman_diterima', 'pengguna', 'year'));
    }

    public function getPeminjamanPerMonth(Request $request, $type, $year)
    {
        switch ($type) {
            case 'ruangan':
                return Borrow::with(['ruangan'])->selectRaw('MONTHNAME(created_at) as month, (SUM(IF(`status` = 1, 1, 0))) AS total')->whereHas('ruangan')->where('status', 1)->whereYear('created_at', $year)->groupByRaw('MONTHNAME(created_at)')->orderByRaw("STR_TO_DATE(CONCAT('0001 ', month, ' 01'), '%Y %M %d')")->get();
                break;
            case 'alat':
                return Borrow::with(['alat'])->selectRaw('MONTHNAME(created_at) as month, (SUM(IF(`status` = 1, 1, 0))) AS total')->whereHas('alat')->whereDoesntHave('ruangan')->where('status', 1)->whereYear('created_at', $year)->groupByRaw('MONTHNAME(created_at)')->orderByRaw("STR_TO_DATE(CONCAT('0001 ', month, ' 01'), '%Y %M %d')")->get();
                break;

            default:
                return response()->json(['total' => 'Invalid']);
                break;
        }
    }
}
