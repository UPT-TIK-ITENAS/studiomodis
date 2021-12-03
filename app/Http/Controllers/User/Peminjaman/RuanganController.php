<?php

namespace App\Http\Controllers\User\Peminjaman;

use App\Alat;
use App\Borrow;
use App\Http\Controllers\Controller;
use App\Http\Resources\RuanganCalendarResource;
use App\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Arr;
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
        $ruangan = Ruangan::where('status', 1)->all();
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
            'jam_awal' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_awal',
            'description' => 'required'
        ]);

        $borrows = Borrow::with('ruangan')->checkAvailability($request->id_ruangan, $request->begin_date, $request->end_date)->count() == 0;
        if (!$borrows) {
            return redirect()->route('user.peminjaman.ruangan.create')->with('danger', 'Ruangan telah dibooking, silakan jadwal ulang!');
        }
        $peminjaman_ruangan = $request->all();
        $peminjaman_ruangan = Arr::except($peminjaman_ruangan, '_token');
        session()->put('peminjaman_ruangan', $peminjaman_ruangan);
        // $peminjaman = Borrow::create([
        //     'begin_date' => $request->begin_date . $request->jam_awal,
        //     'end_date' => $request->end_date . $request->jam_akhir,
        //     'description' => $request->description,
        //     'status' => 0,
        //     'user_id' => auth()->user()->id,
        // ]);

        // $peminjaman->update([
        //     'nomor_surat' =>  $this->generateNomorSurat($peminjaman)
        // ]);

        // $peminjaman->ruangan()->attach([$request->id_ruangan => ['qty' => 1]]);

        return redirect()->route('user.peminjaman.ruangan.alat')->with('success', 'Silakan pilih Alat yang akan dipinjam!');
    }

    public function alat()
    {
        $alat = Alat::where('status', 1)->get();
        $peminjaman_ruangan = session()->get('peminjaman_ruangan');
        // $data['id'] = 1;
        // $data['name'] = "Kabel VGA";
        // $data['qty'] = 1;
        // $data['price'] = 0;
        // $data['weight'] = 0;
        // Cart::add($data);
        // $cart = Cart::content();
        // dd($cart);
        return view('user.peminjaman.ruangan.alat', compact('peminjaman_ruangan', 'alat', 'cart'));
    }

    public function alat_cart(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|numeric',
        ]);
        $alat = Alat::find($id);
        if ($alat->stok < 1) {
            return response()->json(['status' => FALSE, 'message' => 'Stok habis!']);
        }
        if ($request->qty > $alat->stok) {
            return response()->json(['status' => FALSE, 'message' => 'Quantity melebihi stok!']);
        }

        $user_id = auth()->user()->id;
        \Cart::session($user_id)->add([
            'id' => $id,
            'name' => $alat->nama,
            'quantity' => $request->qty,
            'price' => 0,
            'attributes' => array(),
            'associatedModel' => $alat
        ]);

        return response()->json(['status' => TRUE, 'message' => 'Berhasil Memasukkan Data Ke Keranjang']);
    }

    public function alat_list(Request $request)
    {
        if ($request->ajax()) {
            $data = Alat::with(['kategori'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->addColumn('kategori', function ($row) {
                    return $row->kategori->nama;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <a class="btn btn-primary stock" href="" data-id="' . $row->id . '" data-nama="' . $row->nama . '" >
                            <i class="fa fa-plus"></i>
                        </a>
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
