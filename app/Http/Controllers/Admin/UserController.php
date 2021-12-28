<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    public function list(Request $request)
    {
        $data = DB::table('pegawai')->select('users.username, pegawai.*', 'jabatan.*', 'unit.*')->join('users', 'users.username', '=', 'pegawai.nik')->join('unitjabatan', 'unitjabatan.idpegawai', '=', 'pegawai.idpegawai')->join('unit', 'unitjabatan.idunit', '=', 'unit.idunit')->join('jabatan', 'unitjabatan.idjabatan', '=', 'jabatan.idjabatan')->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit_url = route('admin.user.edit', $row->idpegawai);
                // $show_url = route('admin.role.show', $row->id);
                $actionBtn = '
                        <a class="btn btn-info" href="' . $edit_url . '">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-danger hapus_record" data-idpegawai="' . $row->idpegawai . '" data-namapegawai="' . $row->namapegawai . '" data-username="' . $row->username . '" href="#">
                            <i class="fa fa-trash"></i>
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
        $jabatan = DB::table('jabatan')->get();
        $unit = DB::table('unit')->get();
        $pegawai = DB::table('pegawai')->get();
        return view('admin.user.create', compact('jabatan', 'unit', 'pegawai'));
    }

    public function atasan(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $dosen = DB::table('unitjabatan')->selectRaw('pegawai.namapegawai, pegawai.idpegawai,pegawai.nik, unit.namaunit, jabatan.namajabatan')->leftJoin('unit', 'unit.idunit', 'unitjabatan.idunit', 'left')->leftJoin('jabatan', 'jabatan.idjabatan', 'unitjabatan.idjabatan', 'left')->leftJoin('pegawai', 'pegawai.idpegawai', 'unitjabatan.idpegawai', 'left')->get();
        } else {
            $dosen = DB::table('unitjabatan')->selectRaw('pegawai.namapegawai, pegawai.idpegawai,pegawai.nik, unit.namaunit, jabatan.namajabatan')->leftJoin('unit', 'unit.idunit', 'unitjabatan.idunit', 'left')->leftJoin('jabatan', 'jabatan.idjabatan', 'unitjabatan.idjabatan', 'left')->leftJoin('pegawai', 'pegawai.idpegawai', 'unitjabatan.idpegawai', 'left')->where('pegawai.namapegawai', 'like', '%' . $search . '%')->get();
        }
        $response = array();
        foreach ($dosen as $d) {
            $response[] = array(
                "id" => $d->nik,
                "text" => $d->namapegawai . " - " . $d->namajabatan . " " . $d->namaunit,
            );
        }
        return response()->json($response);
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
            'namapegawai' => 'required',
            'nik' => 'required',
            'email' => 'required',
            'nohp' => 'required',
            'atasan_1' => 'required',
            'unit' => 'required',
            'jabatan' => 'required'
        ]);
        DB::transaction(function () use ($request) {
            $pegawai = DB::table('pegawai')->insertGetId([
                'nik' => $request->nik,
                'namapegawai' => $request->namapegawai,
                'email' => $request->email,
                'nohp' => $request->nohp,
                'idtelegram' => $request->idtelegram,
                'nikatasan' => $request->atasan_1,
                'nikatasan2' => $request->atasan_2,
                'is_active' => 1
            ]);
            DB::table('users')->insert([
                'username' => $request->nik,
                'password' => $request->password,
                'role' => 'user',
            ]);
            DB::table('unitjabatan')->insert([
                'idpegawai' => $pegawai,
                'idunit' => $request->unit,
                'idjabatan' => $request->jabatan
            ]);
        });
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Request $request, $id)
    {
        $username = $request->username;
        $pegawai = DB::table('pegawai')->where('idpegawai', $id)->delete();
        $user = DB::table('users')->where('username', $username)->delete();
        DB::table('unitjabatan')->where('idpegawai', $id)->delete();
        return response()->json(['status' => TRUE]);
    }
}
