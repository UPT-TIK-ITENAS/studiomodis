<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\KategoriAlat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kategori.index');
    }

    public function list(Request $request)
    {
        // if ($request->ajax()) {
        $data = KategoriAlat::latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->diffForHumans();
            })
            ->addColumn('action', function ($row) {
                $edit_url = route('admin.kategori.edit', $row->id);
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
        return view('admin.kategori.create');
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
        ]);

        KategoriAlat::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori Alat berhasil dibuat!');
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
    public function edit(KategoriAlat $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KategoriAlat $kategori)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $kategori->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori Alat berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriAlat $kategori)
    {
        $kategori->delete();
        return response()->json(['status' => TRUE]);
    }
}
