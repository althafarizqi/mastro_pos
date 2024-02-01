<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $kategoribarang = KategoriBarang::orderBy('nama','asc')->get();
        
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('kategori.index', compact(['kategoribarang']));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'nama' => 'required|min:3'
        ],
        [
            'nama.required'  =>  'Nama tidak boleh kosong!',
            'nama.min'  =>  'Nama minimal 3 karakter!'
        ]);

        
        KategoriBarang::create([
            'nama'      => $request->nama
        ]);

        return redirect()->route('kategoribarang.index')->withSuccess('Berhasil Simpan Data!');
    }

    public function edit($id)
    {
        $kategoribarang = KategoriBarang::findOrFail($id);
        

        return view('kategori.edit', compact('kategoribarang'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $kategoribarang = KategoriBarang::findOrFail($id);

        $kategoribarang->update($input);
        return redirect()->route('kategoribarang.index')->withSuccess('Anda berhasil mengubah barang '.$kategoribarang->nama);
    }

    public function destroy($id)
    {
        $kategoribarang = KategoriBarang::findOrFail($id);

        KategoriBarang::destroy($id);
        return redirect()->back()->withSuccess('Anda berhasil menghapus kategori '.$kategoribarang->nama);
    }
}