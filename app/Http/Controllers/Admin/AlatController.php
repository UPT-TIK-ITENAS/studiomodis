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
        if ($request->ajax()) {
            $data = Alat::with(['kategori'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('photo', function ($row) {
                    if ($row->photo == null) {
                        return '<img src="https://via.placeholder.com/150" data-src="https://via.placeholder.com/150" alt="Square placeholder image"/>';
                    } else {
                        return '<img src="' . asset('assets/images/alat/' . $row->photo) . '" style="max-width:150px;max-height:150px;" />';
                    }
                })
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
                ->rawColumns(['action', 'photo'])
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
            'photo' => 'required|file|mimes:jpeg,jpg,png,webp,bmp'
        ]);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = $photo->getClientOriginalName();
            $photo_name = preg_replace('!\s+!', ' ', $photo_name);
            $photo_name = str_replace(' ', '_', $photo_name);
            $photo_name = str_replace('%', '', $photo_name);
            $photo->move(public_path('assets/images/alat'), $photo_name);
            Alat::create([
                'nama' => $request->nama,
                'stok' => $request->stok,
                'kategori_alat_id' => $request->kategori_alat_id,
                'deskripsi' => $request->deskripsi,
                'photo' => $photo_name,
                'status' => $request->status,
            ]);
            return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dibuat!');
        } else {
            return redirect()->route('admin.alat.create')->with('error', 'Upload foto terlebih dahulu!');
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
            'photo' => 'sometimes|required|file|mimes:jpeg,jpg,png,webp,bmp'
        ]);
        $photo_name = $alat->photo;
        if ($request->hasFile('photo')) {
            if ($alat->photo != null) {
                if (file_exists('./assets/images/alat/' . $photo_name)) {
                    unlink(public_path('assets/images/alat/' . $photo_name));
                }
            }
            $photo = $request->file('photo');
            $photo_name = $photo->getClientOriginalName();
            $photo_name = preg_replace('!\s+!', ' ', $photo_name);
            $photo_name = str_replace(' ', '_', $photo_name);
            $photo_name = str_replace('%', '', $photo_name);
            $photo->move(public_path('assets/images/alat/'), $photo_name);
            $alat->update([
                'nama' => $request->nama,
                'stok' => $request->stok,
                'kategori_alat_id' => $request->kategori_alat_id,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
                'photo' => $photo_name
            ]);
            return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diubah!');
        } else {
            $alat->update([
                'nama' => $request->nama,
                'stok' => $request->stok,
                'kategori_alat_id' => $request->kategori_alat_id,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status
            ]);

            return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alat $alat)
    {
        $photo_name = $alat->photo;
        if ($alat->photo != null) {
            if (file_exists('./assets/images/alat/' . $photo_name)) {
                unlink(public_path('assets/images/alat/' . $photo_name));
            }
        }
        $alat->delete();
        return response()->json(['status' => TRUE]);
    }
}
