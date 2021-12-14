<?php

namespace App\Http\Controllers\User\Peminjaman;

use App\Borrow;
use App\Alat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AlatController extends Controller
{
    public function index()
    {
        return view('user.peminjaman.alat.index');
    }

    public function peminjaman()
    {
        return view('user.peminjaman.alat.peminjaman');
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'begin_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:begin_date',
            'jam_awal' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_awal',
            'description' => 'required'
        ]);

        $peminjaman = $request->all();
        $peminjaman = Arr::except($peminjaman, '_token');
        session()->put('peminjaman', $peminjaman);
        return redirect()->route('user.peminjaman.alat.create')->with('success', 'Silakan pilih Alat yang akan dipinjam!');
    }

    public function listPeminjaman(Request $request)
    {
        if ($request->ajax()) {
            $data = Borrow::with(['alat'])->whereHas('alat')->latest()->where('user_id', auth()->user()->id)->get();
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
                ->addColumn('action', function ($row) {
                    $show_url = route('user.peminjaman.alat.show', $row->id);
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

    public function list(Request $request, $type)
    {
        if ($request->ajax()) {
            if ($type == "cart") {
                $csrf_field = csrf_field();
                $url_update = route('user.peminjaman.alat.updateCart');
                $url_delete = route('user.peminjaman.alat.deleteCart');
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

    public function store(Request $request)
    {
    }

    public function create()
    {
        $alat = Alat::where('status', 1)->get();
        $peminjaman_ruangan = session()->get('peminjaman_ruangan');
        $cart = \Cart::session(auth()->user()->id)->getContent();
        return view('user.peminjaman.alat.create', compact('peminjaman_ruangan', 'alat', 'cart'));
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
            return redirect()->route('user.peminjaman.alat.create')->with('danger', 'Stok habis!');
        }
        if ($request->quantity > $alat->stok) {
            return redirect()->route('user.peminjaman.alat.create')->with('danger', 'Quantity melebihi stok!');
        }

        \Cart::session(auth()->user()->id)->update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]);

        return redirect()->route('user.peminjaman.alat.create')->with('success', 'Berhasil mengupdate cart!');
    }

    public function deleteCart(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
        ]);

        \Cart::session(auth()->user()->id)->remove($request->id);

        return redirect()->route('user.peminjaman.alat.create')->with('success', 'Berhasil menghapus item pada cart!');
    }

    public function addToCart(Request $request, $id)
    {

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
    }

    public function confirm()
    {
        $peminjaman_alat = \Cart::session(auth()->user()->id)->getContent();
        session()->put('peminjaman_alat', $peminjaman_alat);
        // dd($peminjaman_ruangan);
        return view('user.peminjaman.alat.confirm', compact('peminjaman_alat'));
    }

    public function confirmStore(Request $request)
    {
        if (session()->get('peminjaman_alat')) {
            $peminjaman = session()->get('peminjaman');
            $peminjaman_alat = session()->get('peminjaman_alat');
            $peminjaman_alat = $peminjaman_alat->toArray();
            $peminjaman = Borrow::create([
                'begin_date' => $peminjaman['begin_date'] . " "  . $peminjaman['jam_awal'],
                'end_date' => $peminjaman['end_date'] . " " . $peminjaman['jam_akhir'],
                'description' => $peminjaman['description'],
                'status' => 0,
                'user_id' => auth()->user()->id,
            ]);

            $peminjaman->update([
                'nomor_surat' =>  $this->generateNomorSurat($peminjaman)
            ]);

            $peminjaman->ruangan()->attach([$peminjaman['id_ruangan'] => ['qty' => 1]]);

            foreach ($peminjaman_alat as $pa) {
                $peminjaman->alat()->attach([$pa['id'] => ['qty' => $pa['quantity']]]);
                $alat = Alat::find($pa['id']);
                $alat->update([
                    'stok' => $alat->stok - $pa['quantity']
                ]);
            }
            session()->forget(['peminjaman_alat']);
            return redirect()->route('user.peminjaman.alat.index')->with('success', 'Berhasil booking alat dan alat!');
        } else {
            return redirect()->route('user.peminjaman.alat.index')->with('danger', 'Mohon untuk pilih alat dan alat terlebih dahulu!');
        }
    }

    public function show($id)
    {
        $borrow = Borrow::with(['alat'])->whereHas('alat')->findOrFail($id);
        return view('user.peminjaman.alat.show', compact('borrow'));
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

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
