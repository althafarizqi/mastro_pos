<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hutang;

class HutangController extends Controller
{
    public function index()
    {
        // $laporans = Hutang::orderBy('tanggal_japo','asc')->get();
        $hutangs = Hutang::where('status', 'Belum Lunas')
            ->orderBy('tanggal_japo', 'asc')
            ->get();

        $title = 'Pelunasan Hutang';
        $text = "Yakin uang sudah dibayarkan?";
        confirmDelete($title, $text);

        return view('hutang.index', compact(['hutangs']));
    }

    
    public function update(Request $request, $id)
    {
        $hutang = Hutang::findOrFail($id);
        $hutang->status = 'Lunas';
        $hutang->update();
        
        return redirect()->route('hutang.index')->withSuccess('Alhamdulillah Hutangku Lunas!');
    }
}