<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    public function index()
    {
        $supliers = Suplier::orderBy('nama','asc')->get();
        
        return view('suplier.index', compact(['supliers']));
    }

    public function create()
    {
        return view('suplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
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

        Suplier::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);
        return redirect()->route('suplier.index')->withSuccess('Simpan Data Berhasil!');
    }

    public function edit($id)
    {
        $supliers = Suplier::findOrFail($id);
        
        return view('suplier.edit', compact('supliers'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $supliers = Suplier::findOrFail($id);

        $supliers->update($input);
        return redirect()->route('suplier.index')->withSuccess('Anda berhasil mengubah suplier '.$supliers->nama);
    }

    public function destroy($id)
    {
        $supliers = Suplier::findOrFail($id);
        Suplier::destroy($id);
        return redirect()->back()->withSuccess('Anda berhasil menghapus  '.$supliers->nama);
    }
}