<?php

namespace App\Http\Controllers\User\Peminjaman;

use App\Alat;
use App\Borrow;
use App\Http\Controllers\Controller;
use App\Http\Resources\RuanganCalendarResource;
use App\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class RuanganController extends Controller
{
    public function index()
    {
        return view('user.peminjaman.ruangan.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Borrow::with(['ruangan'])->whereHas('ruangan')->latest()->where('user_id', auth()->user()->id)->get();
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
                    $show_url = route('user.peminjaman.ruangan.show', $row->id);
                    // $show_url = route('admin.role.show', $row->id);
                    if ($row->status == 0) {
                        $actionBtn = '
                            <a class="btn btn-secondary btn-sm" href="' . $show_url . '">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-danger btn-sm hapus_record" data-id="' . $row->id . '" data-nama="' . $row->nama . '" href="#">
                                <i class="fa fa-trash"></i>
                            </a>
                            ';
                    } else if ($row->status == 1 || $row->status == 2) {
                        $actionBtn = '
                        <a class="btn btn-secondary btn-sm" href="' . $show_url . '">
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
        $ruangan = Ruangan::where('status', 1)->get();
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
        $ruangan = Ruangan::find($request->id_ruangan);
        if (!$borrows) {
            return redirect()->route('user.peminjaman.ruangan.create')->with('danger', 'Ruangan telah dibooking, silakan jadwal ulang!');
        }
        $peminjaman_ruangan = $request->all();
        $peminjaman_ruangan = Arr::except($peminjaman_ruangan, '_token');
        $peminjaman_ruangan = Arr::add($peminjaman_ruangan, 'nama_ruangan', $ruangan->nama);
        $peminjaman_ruangan = Arr::add($peminjaman_ruangan, 'nomor_ruangan', $ruangan->no_ruangan);
        session()->put('peminjaman_ruangan', $peminjaman_ruangan);
        return redirect()->route('user.peminjaman.ruangan.alat')->with('success', 'Silakan pilih Alat yang akan dipinjam!');
    }

    public function alat()
    {
        if (session()->get('peminjaman_ruangan')) {
            $alat = Alat::where('status', 1)->get();
            $peminjaman_ruangan = session()->get('peminjaman_ruangan');
            $cart = \Cart::session(auth()->user()->id)->getContent();
            return view('user.peminjaman.ruangan.alat', compact('peminjaman_ruangan', 'alat', 'cart'));
        } else {
            return redirect()->route('user.peminjaman.ruangan.index')->with('danger', 'Mohon untuk pilih ruangan terlebih dahulu!');
        }
    }

    public function alat_cart(Request $request, $id)
    {
        if (session()->get('peminjaman_ruangan')) {
            $request->validate([
                'qty' => 'required|numeric',
            ]);
            $alat = Alat::with(['kategori'])->find($id);
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

            return response()->json(['status' => TRUE, 'message' => 'Berhasil Memasukkan Data Ke Keranjang', 'data' => \Cart::session($user_id)->getContent()->count()]);
        } else {
            return redirect()->route('user.peminjaman.ruangan.index')->with('danger', 'Mohon untuk pilih ruangan terlebih dahulu!');
        }
    }

    public function alat_list(Request $request, $type)
    {
        if ($request->ajax()) {
            if ($type == "cart") {
                $csrf_field = csrf_field();
                $url_update = route('user.peminjaman.ruangan.updateCart');
                $url_delete = route('user.peminjaman.ruangan.deleteCart');
                return DataTables::of(\Cart::session(auth()->user()->id)->getContent())
                    ->addIndexColumn()
                    ->editColumn('quantity', function ($row) use ($csrf_field, $url_update) {
                        $actionBtn = "
                        <form action='$url_update' method='POST'>
                            $csrf_field
                            <input name='_method' value='PUT' type='hidden'>
                            <input name='id' value='$row->id' type='hidden'>
                            <input name='quantity' value='$row->quantity' type='number' class='form-control'>
                            <div class='d-flex justify-content-center mt-3'>
                                <button class='btn btn btn-info text-center' type='submit'>Update</button>
                            </div>
                        </form>
                        ";
                        return $actionBtn;
                    })
                    ->addColumn('action', function ($row) use ($csrf_field, $url_delete) {
                        $actionBtn = "
                            <form action='$url_delete' method='POST'>
                                $csrf_field
                                <input name='_method' value='DELETE' type='hidden'>
                                <input name='id' value='$row->id' type='hidden'>
                                <button type='submit' class='btn btn-sm btn-danger'>
                                    <i class='fa fa-trash'></i>
                                </button>
                            </form>
                            ";
                        return $actionBtn;
                    })
                    ->rawColumns(['action', 'quantity'])
                    ->make(true);
            } else if ($type == "alat") {
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
            } else if ($type == "confirm") {
                return DataTables::of(\Cart::session(auth()->user()->id)->getContent())
                    ->addIndexColumn()
                    ->rawColumns([])
                    ->make(true);
            }
        }
    }

    public function generateNomorSurat(Borrow $borrow)
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        return "$borrow->id/$bulan/STUDIO MODIS/$tahun";
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        // dd($request->all());
        $alat = Alat::with(['kategori'])->find($request->id);
        if ($alat->stok < 1) {
            return redirect()->route('user.peminjaman.ruangan.alat')->with('danger', 'Stok habis!');
        }
        if ($request->quantity > $alat->stok) {
            return redirect()->route('user.peminjaman.ruangan.alat')->with('danger', 'Quantity melebihi stok!');
        }

        \Cart::session(auth()->user()->id)->update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]);

        return redirect()->route('user.peminjaman.ruangan.alat')->with('success', 'Berhasil mengupdate cart!');
    }

    public function deleteCart(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
        ]);

        \Cart::session(auth()->user()->id)->remove($request->id);

        return redirect()->route('user.peminjaman.ruangan.alat')->with('success', 'Berhasil menghapus item pada cart!');
    }

    public function confirm()
    {
        if (session()->get('peminjaman_ruangan')) {
            $peminjaman_alat = \Cart::session(auth()->user()->id)->getContent();
            session()->put('peminjaman_alat', $peminjaman_alat);
            $peminjaman_ruangan = session()->get('peminjaman_ruangan');
            // dd($peminjaman_ruangan);
            return view('user.peminjaman.ruangan.confirm', compact('peminjaman_alat', 'peminjaman_ruangan'));
        } else {
            return redirect()->route('user.peminjaman.ruangan.index')->with('danger', 'Mohon untuk pilih ruangan dan alat terlebih dahulu!');
        }
    }

    public function confirmStore(Request $request)
    {
        if (session()->get('peminjaman_ruangan') || session()->get('peminjaman_alat')) {
            $peminjaman_ruangan = session()->get('peminjaman_ruangan');
            $peminjaman_alat = session()->get('peminjaman_alat');
            $peminjaman_alat = $peminjaman_alat->toArray();
            $peminjaman = Borrow::create([
                'begin_date' => $peminjaman_ruangan['begin_date'] . " "  . $peminjaman_ruangan['jam_awal'],
                'end_date' => $peminjaman_ruangan['end_date'] . " " . $peminjaman_ruangan['jam_akhir'],
                'description' => $peminjaman_ruangan['description'],
                'status' => 0,
                'user_id' => auth()->user()->id,
            ]);

            $peminjaman->update([
                'nomor_surat' =>  $this->generateNomorSurat($peminjaman)
            ]);

            $peminjaman->ruangan()->attach([$peminjaman_ruangan['id_ruangan'] => ['qty' => 1]]);

            foreach ($peminjaman_alat as $pa) {
                $peminjaman->alat()->attach([$pa['id'] => ['qty' => $pa['quantity']]]);
                $alat = Alat::find($pa['id']);
                $alat->update([
                    'stok' => $alat->stok - $pa['quantity']
                ]);
            }
            session()->forget(['peminjaman_ruangan', 'peminjaman_alat']);
            return redirect()->route('user.peminjaman.ruangan.index')->with('success', 'Berhasil booking ruangan dan alat!');
        } else {
            return redirect()->route('user.peminjaman.ruangan.index')->with('danger', 'Mohon untuk pilih ruangan dan alat terlebih dahulu!');
        }
    }

    public function show($id)
    {
        $borrow = Borrow::with(['ruangan', 'alat'])->whereHas('ruangan')->findOrFail($id);
        return view('user.peminjaman.ruangan.show', compact('borrow'));
    }

    public function alat_show(Request $request, $id)
    {
        $borrow = Borrow::with(['alat'])->findOrFail($id);
        if ($request->ajax()) {
            return DataTables::of($borrow->alat)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    return $row->nama;
                })
                ->addColumn('qty', function ($row) {
                    return $row->pivot->qty;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy($id)
    {
        $borrow = Borrow::with(['ruangan', 'alat'])->findOrFail($id);
        foreach ($borrow->alat as $alat) {
            $alat_f = Alat::find($alat->id);
            $alat_f->update([
                'stok' => $alat_f->stok + $alat->pivot->qty
            ]);
        }
        $borrow->delete();
        return response()->json(['status' => TRUE]);
    }
}
