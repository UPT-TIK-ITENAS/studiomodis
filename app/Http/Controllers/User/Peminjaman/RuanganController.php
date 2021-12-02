<?php

namespace App\Http\Controllers\User\Peminjaman;

use App\Borrow;
use App\Http\Controllers\Controller;
use App\Http\Resources\RuanganCalendarCollection;
use App\Http\Resources\RuanganCalendarResource;
use App\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RuanganController extends Controller
{
    public function index()
    {
        // $data = Borrow::with(['ruangan'])->latest()->where('user_id', auth()->user()->id)->get();
        // dd($data);
        return view('user.peminjaman.ruangan.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Borrow::with(['ruangan'])->latest()->where('user_id', auth()->user()->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->editColumn('status', function ($row) {
                    return ($row->status == 0) ? "Menunggu" : ($row->status == 1 ?  "Disetujui" : "Ditolak");
                })
                ->addColumn('nama_ruangan', function ($row) {
                    return $row->ruangan[0]->nama;
                })
                ->addColumn('nomor_ruangan', function ($row) {
                    return $row->ruangan[0]->no_ruangan;
                })
                ->addColumn('action', function ($row) {
                    $edit_url = route('user.peminjaman.ruangan.edit', $row->id);
                    $edit_url = route('user.peminjaman.ruangan.show', $row->id);
                    // $show_url = route('admin.role.show', $row->id);
                    if ($row->status == 0) {
                        $actionBtn = '
                            <a class="btn btn-secondary btn-sm" href="' . $edit_url . '">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-info btn-sm" href="' . $edit_url . '">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-danger btn-sm hapus_record" data-id="' . $row->id . '" data-nama="' . $row->nama . '" href="#">
                                <i class="fa fa-trash"></i>
                            </a>
                            ';
                    } else if ($row->status == 1 || $row->status == 2) {
                        $actionBtn = '
                        <a class="btn btn-secondary btn-sm" href="' . $edit_url . '">
                            <i class="fa fa-eye"></i>
                        </a>
                        ';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $ruangan = Ruangan::all();
        return view('user.peminjaman.ruangan.create', compact('ruangan'));
    }

    public function checkRuangan(Request $request)
    {

        if ($request->ruangan != null) {
            $data = Borrow::with(['ruangan', 'user'])->whereDate('begin_date', '>=', $request->start)->whereDate('end_date', '<=', $request->end)->get();
            return RuanganCalendarResource::collection($data);
        } else {
            $data = Borrow::with(['ruangan', 'user'])->whereDate('begin_date', '>=', $request->start)->whereDate('end_date', '<=', $request->end)->whereHas(
                'ruangan',
                function ($query) use ($request) {
                    $query->where('id', $request->ruangan);
                }
            )->get();
            return RuanganCalendarResource::collection($data);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'begin_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:begin_date',
            'id_ruangan' => 'required|numeric',
            'description' => 'required'
        ]);

        $borrows = Borrow::with('ruangan')->checkAvailability($request->id_ruangan, $request->begin_date, $request->end_date)->count() == 0;
        if (!$borrows) {
            return redirect()->route('user.peminjaman.ruangan.create')->with('danger', 'Ruangan telah dibooking, silakan jadwal ulang!');
        }

        $peminjaman = Borrow::create([
            'begin_date' => $request->begin_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'status' => 0,
            'user_id' => auth()->user()->id,
        ]);

        $peminjaman->update([
            'nomor_surat' =>  $this->generateNomorSurat($peminjaman)
        ]);

        $peminjaman->ruangan()->attach([$request->id_ruangan => ['qty' => 1]]);

        return redirect()->route('user.peminjaman.ruangan.index')->with('success', 'Ruangan berhasil dibooking!');
    }

    public function generateNomorSurat(Borrow $borrow)
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        return "$borrow->id/$bulan/STUDIO MODIS/$tahun";
    }

    public function show()
    {
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
