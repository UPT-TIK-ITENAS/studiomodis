<?php

namespace App\Http\Controllers\Admin;

use App\Alat;
use App\Http\Controllers\Controller;
use App\KategoriAlat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.alat.index');
    }

    public function list(Request $request)
    {
        // if ($request->ajax()) {
        $data = Alat::with(['kategori'])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->diffForHumans();
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 0)
                    return 'Tidak Aktif';
                else
                    return 'Aktif';
            })
            ->addColumn('kategori', function ($row) {
                return $row->kategori->nama;
            })
            ->addColumn('action', function ($row) {
                $edit_url = route('admin.alat.edit', $row->id);
                // $show_url = route('admin.role.show', $row->id);
                $actionBtn = '
                        <a class="btn btn-info" href="' . $edit_url . '">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-danger hapus_record" data-id="' . $row->id . '" data-nama="' . $row->nama . '" href="#">
                            <i class="fa fa-trash"></i>
                        </a>
                        ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = KategoriAlat::all();
        return view('admin.alat.create', compact('kategori'));
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
            'nama' => 'required',
            'stok' => 'required|numeric',
            'deskripsi' => 'required',
            'kategori_alat_id' => 'required',
            'status' => 'required',
        ]);

        Alat::create([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'kategori_alat_id' => $request->kategori_alat_id,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dibuat!');
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
    public function edit(Alat $alat)
    {
        $kategori = KategoriAlat::all();
        return view('admin.alat.edit', compact('alat', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama' => 'required',
            'stok' => 'required|numeric',
            'deskripsi' => 'required',
            'kategori_alat_id' => 'required',
            'status' => 'required',
        ]);

        $alat->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'kategori_alat_id' => $request->kategori_alat_id,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alat $alat)
    {
        $alat->delete();
        return response()->json(['status' => TRUE]);
    }
}
