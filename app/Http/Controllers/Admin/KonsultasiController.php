<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Konsultasi;
use App\Pegawai;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
        return view('admin.konsultasi.index');
    }

    public function list(Request $request)
    {
        $konsultasi = Konsultasi::with(['user', 'pic'])->latest()->get();
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
                $data = DB::table('users')->where('id', $row->pic_id)->join('pegawai', 'pegawai.nik', '=', 'users.username')->first();
                return $row->pic_id ? $data->namapegawai : '-';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '
                <a class="btn btn-info btn-sm edit_record" data-id="' . $row->id . '">
                    <i class="fa fa-edit"></i>
                </a>
                <a class="btn btn-danger btn-sm hapus_record" data-id="' . $row->id . '" data-subjek="' . $row->subjek . '" href="#">
                    <i class="fa fa-trash"></i>
                </a>
                        ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function pic(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $data = DB::table('pegawai')->join('unitjabatan', 'unitjabatan.idpegawai', '=', 'pegawai.idpegawai')->join('unit', 'unit.idunit', '=', 'unitjabatan.idunit')->join('users', 'users.username', '=', 'pegawai.nik')->where('unit.idunit', '=', 31)->get();
        } else {
            $data =  DB::table('pegawai')->join('unitjabatan', 'unitjabatan.idpegawai', '=', 'pegawai.idpegawai')->join('unit', 'unit.idunit', '=', 'unitjabatan.idunit')->join('users', 'users.username', '=', 'pegawai.nik')->where('unit.idunit', '=', 31)->where('pegawai.namapegawai', 'like', '%' . $search . '%')->get();
        }
        $response = array();
        foreach ($data as $d) {
            $response[] = array(
                "id" => $d->id,
                "text" => $d->namapegawai,
            );
        }
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.konsultasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $konsultasi = Konsultasi::with(['user', 'pic'])->findOrFail($id);
        return response()->json([
            'konsultasi' => $konsultasi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Konsultasi $konsultasi)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Konsultasi $konsultasi)
    {
        $request->validate([
            'pic' => 'required',
        ]);

        $konsultasi->update([
            'pic_id' => $request->pic,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'PIC berhasil diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Konsultasi $konsultasi)
    {
        if (File::exists(public_path('assets/materi/' . $konsultasi->materi))) {
            File::delete(public_path('assets/materi/' . $konsultasi->materi));
        }
        $konsultasi->delete();
        return response()->json(['status' => TRUE]);
    }
}
