<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Ruangan;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use Yajra\DataTables\Facades\DataTables;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ruangan.index');
    }

    public function list(Request $request)
    {
        // if ($request->ajax()) {
        $data = Ruangan::latest()->get();
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
            ->addColumn('action', function ($row) {
                $edit_url = route('admin.ruangan.edit', $row->id);
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
        return view('admin.ruangan.create');
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
            'no_ruangan' => 'required',
            'deskripsi' => 'required',
            'status' => 'required',
        ]);

        Ruangan::create([
            'nama' => $request->nama,
            'no_ruangan' => $request->no_ruangan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan berhasil dibuat!');
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
    public function edit(Ruangan $ruangan)
    {
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama' => 'required',
            'no_ruangan' => 'required',
            'deskripsi' => 'required',
            'status' => 'required',
        ]);

        $ruangan->update([
            'nama' => $request->nama,
            'no_ruangan' => $request->no_ruangan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return response()->json(['status' => TRUE]);
    }
}
