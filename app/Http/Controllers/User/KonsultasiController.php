<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KonsultasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.konsultasi.index');
    }

    public function list(Request $request)
    {
        $user = $request->user();
        $konsultasi = $user->konsultasi()->with(['user', 'pic'])->latest()->get();
        return DataTables::of($konsultasi)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->diffForHumans();
            })
            ->editColumn('status', function ($row) {
                return ($row->status == 1) ? "Pre Production" : ($row->status == 2 ?  "Production" : "Post Production");
            })
            ->addColumn('pic_text', function ($row) {
                $pic = DB::table('users')->join('pegawai', 'pegawai.nik', '=', 'users.username')->join('unitjabatan', 'unitjabatan.idpegawai', '=', 'pegawai.idpegawai')->where('users.id', '=', $row->pic_id)->first();
                return $pic ? $pic->namapegawai : '-';
            })
            ->addColumn('action', function ($row) {
                $show_url = route('user.konsultasi.show', $row->id);

                $actionBtn = '
                        <a class="btn btn-secondary btn-sm" href="' . $show_url . '">
                            <i class="fa fa-eye"></i>
                        </a>
                        ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.konsultasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:1,2,3',
            'subjek' => 'required',
            'deskripsi' => 'required',
            'materi' => 'required|file',
        ]);

        // dd($request->all());

        $user = $request->user();
        if ($request->hasFile('materi')) {
            $materi = $request->file('materi');
            $materi_name = time() . '_' . $materi->getClientOriginalName();
            $materi_name = preg_replace('!\s+!', ' ', $materi_name);
            $materi_name = str_replace(' ', '_', $materi_name);
            $materi_name = str_replace('%', '', $materi_name);
            $materi->move(public_path("assets/materi"), $materi_name);
            $user->konsultasi()->create([
                'status' => $request->status,
                'subjek' => $request->subjek,
                'deskripsi' => $request->deskripsi,
                'materi' => $materi_name,
                'user_id' => $user->id,
            ]);
            return redirect()->route('user.konsultasi.index')->with('success', 'Konsultasi berhasil dibuat');
        } else {
            return redirect()->back()->with('error', 'File materi harus diisi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
        $pic = DB::table('users')->join('pegawai', 'pegawai.nik', '=', 'users.username')->join('unitjabatan', 'unitjabatan.idpegawai', '=', 'pegawai.idpegawai')->where('users.id', '=', $konsultasi->pic_id)->first();
        // <option value="1" @if (old('status') == 1) selected @endif>Pre-Production
        // </option>
        // <option value="2" @if (old('status') == 2) selected @endif>Production
        // </option>
        // <option value="3" @if (old('status') == 3) selected @endif>Post-Production
        // </option>
        $status = ($konsultasi->status == 1) ? 'Pre-Production' : (($konsultasi->status == 2) ? 'Production' : 'Post-Production');
        return view('user.konsultasi.show', compact('konsultasi', 'pic', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
