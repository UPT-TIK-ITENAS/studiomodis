<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SumberDaya;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class SumberDayaController extends Controller
{
    private $url_dokumen = 'dokumen/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sumber-daya.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = SumberDaya::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('file_dokumen', function ($row) {
                    $url_dokumen = asset($this->url_dokumen . $row->file_dokumen);
                    return "<a href='$url_dokumen' target='_blank' class='btn btn-md btn-primary'><i class='fas fa-cloud-download-alt mr-1'></i></a>";
                })
                ->editColumn('status', function ($row) {
                    return ($row->status == 0) ? "Tidak Aktif" : "Aktif";
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('action', function ($row) {
                    $edit_url = route('admin.sumber-daya.edit', $row->id);
                    $actionBtn = '
                <a class="btn btn-info" href="' . $edit_url . '">
                    <i class="fas fa-edit"></i>
                </a>
                <a class="btn btn-danger hapus_record" data-id="' . $row->id . '" data-nama="' . $row->nama_dokumen . '" href="#">
                    <i class="fas fa-trash"></i>
                </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'kegiatan', 'file_dokumen'])
                ->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sumber-daya.create');
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
            'nama_dokumen' => 'required|min:5',
            'file_dokumen' => 'required|file|mimes:pdf',
            'status' => 'required|integer',
        ]);

        if ($request->hasFile('file_dokumen')) {
            $file_dokumen = $request->file('file_dokumen');
            $file_dokumen_name = $file_dokumen->getClientOriginalName();
            $file_dokumen_name = preg_replace('!\s+!', ' ', $file_dokumen_name);
            $file_dokumen_name = str_replace(' ', '_', $file_dokumen_name);
            $file_dokumen_name = str_replace('%', '', $file_dokumen_name);
            $file_dokumen->move(public_path($this->url_dokumen), $file_dokumen_name);
            SumberDaya::create([
                'nama_dokumen' => $request->nama_dokumen,
                'file_dokumen' => $file_dokumen_name,
                'status' => $request->status,
            ]);
            return redirect()->route('admin.sumber-daya.index')->with('success', 'Dokumen sumber daya berhasil dibuat!');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SumberDaya $sumberDaya, Request $request)
    {
        return view('admin.sumber-daya.edit', compact('sumberDaya'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SumberDaya $sumberDaya)
    {
        $this->validate($request, [
            'nama_dokumen' => 'required|min:5',
            'file_dokumen' => 'file|mimes:pdf',
            'status' => 'required|integer',
        ]);

        $file_dokumen_name = $sumberDaya->file_dokumen;
        if ($request->hasFile('file_dokumen')) {
            if (file_exists('./' . $this->url_dokumen . $file_dokumen_name)) {
                unlink(public_path($this->url_dokumen . $file_dokumen_name));
            }
            $file_dokumen = $request->file('file_dokumen');
            $file_dokumen_name = $file_dokumen->getClientOriginalName();
            $file_dokumen_name = preg_replace('!\s+!', ' ', $file_dokumen_name);
            $file_dokumen_name = str_replace(' ', '_', $file_dokumen_name);
            $file_dokumen_name = str_replace('%', '', $file_dokumen_name);
            $file_dokumen->move(public_path($this->url_dokumen), $file_dokumen_name);
        }
        $sumberDaya->update([
            'nama_dokumen' => $request->nama_dokumen,
            'file_dokumen' => $file_dokumen_name,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.sumber-daya.index')->with('success', 'Dokumen sumber daya berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SumberDaya $sumberDaya)
    {
        $path_file = public_path($this->url_dokumen . $sumberDaya->file_dokumen);
        if (File::exists($path_file)) {
            unlink($path_file);
        }
        $sumberDaya->delete();
        return response()->json(['status' => TRUE]);
    }
}
