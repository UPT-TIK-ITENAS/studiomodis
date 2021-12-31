<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function edit()
    {
        $user =  DB::table('pegawai')->select('users.username', 'users.password', 'pegawai.*', 'jabatan.*', 'unit.*')->join('users', 'users.username', '=', 'pegawai.nik')->join('unitjabatan', 'unitjabatan.idpegawai', '=', 'pegawai.idpegawai')->join('unit', 'unitjabatan.idunit', '=', 'unit.idunit')->join('jabatan', 'unitjabatan.idjabatan', '=', 'jabatan.idjabatan')->where('users.username', '=', auth()->user()->username)->first();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'namapegawai' => 'required',
            'email' => 'required',
            'nohp' => 'required',
            'password' => 'required',
        ]);
        $user =  DB::table('pegawai')->select('users.username', 'users.password', 'pegawai.*', 'jabatan.*', 'unit.*')->join('users', 'users.username', '=', 'pegawai.nik')->join('unitjabatan', 'unitjabatan.idpegawai', '=', 'pegawai.idpegawai')->join('unit', 'unitjabatan.idunit', '=', 'unit.idunit')->join('jabatan', 'unitjabatan.idjabatan', '=', 'jabatan.idjabatan')->where('users.username', '=', auth()->user()->username);
        DB::transaction(function () use ($request, $user) {
            DB::table('users')->where('username', '=', auth()->user()->username)->update([
                'password' => $request->password,
            ]);
            $user->update([
                'namapegawai' => $request->namapegawai,
                'email' => $request->email,
                'nohp' => $request->nohp,
                'idtelegram' => $request->idtelegram,
            ]);
        });

        return redirect()->back()->with('success', 'Profile berhasil diubah!');
    }
}
