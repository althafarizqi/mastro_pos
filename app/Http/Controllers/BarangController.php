<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::orderBy('kategori_id','asc')->get();
        
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = KategoriBarang::orderBy('nama','asc')->get();
        return view('barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required|min:3',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ],
        [
            'kategori.required'  =>  'Kategori tidak boleh kosong!',
            'nama.required'  =>  'Nama tidak boleh kosong!',
            'nama.min'  =>  'Nama minimal 3 karakter!',
            'harga.required'  =>  'Harga tidak boleh kosong!',
            'stok.numeric'  =>  'Harga harus angka!',
            'stok.required'  =>  'Stok tidak boleh kosong!',
            'stok.numeric'  =>  'Stok harus angka!'
        ]);

        
        Barang::create([
            'kategori_id' => $request->kategori_id,
            'nama'      => $request->nama,
            'harga'    => $request->harga,
            'stok'   => $request->stok,
        ]);

        return redirect()->route('barang.index')->withSuccess('Simpan Data Berhasil!');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = KategoriBarang::orderBy('nama', 'asc')->get();

        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $barang = Barang::findOrFail($id);

        $barang->update($input);
        return redirect()->route('barang.index')->withSuccess('Anda berhasil mengubah barang '.$barang->nama);
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        Barang::destroy($id);
        return redirect()->back()->withSuccess('Anda berhasil menghapus  '.$barang->nama);
    }
}