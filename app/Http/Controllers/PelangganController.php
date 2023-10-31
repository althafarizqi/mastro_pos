<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
Use Alert;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::orderBy('nama','asc')->get();

        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('pelanggan.index', compact(['pelanggans']));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'nama' => 'required|min:3',
            'alamat' => 'required',
            'telepon' => 'required|numeric'
        ],
        [
            'nama.required'  =>  'Nama tidak boleh kosong!',
            'nama.min'  =>  'Nama minimal 3 karakter!',
            'alamat.required'  =>  'Alamat tidak boleh kosong!',
            'telepon.required'  =>  'Telepon tidak boleh kosong!',
            'telepon.numeric'  =>  'Telepon harus angka!'
        ]);

        
        Pelanggan::create([
            'nama'      => $request->nama,
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
        ]);

        return redirect()->route('pelanggan.index')->withSuccess('Simpan Data Berhasil!');
    }

    public function edit($id)
    {
        $pelanggans = Pelanggan::findOrFail($id);
        
        return view('pelanggan.edit', compact('pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $pelanggans = Pelanggan::findOrFail($id);

        $pelanggans->update($input);
        return redirect()->route('pelanggan.index')->withSuccess('Anda berhasil mengubah pelanggan '.$pelanggans->nama);
    }

    public function destroy($id)
    {
        $pelanggans = Pelanggan::findOrFail($id);
        Pelanggan::destroy($id);
        return redirect()->back()->withSuccess('Anda berhasil menghapus  '.$pelanggans->nama);
    }
}