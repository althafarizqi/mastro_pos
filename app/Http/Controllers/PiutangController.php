<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Piutang;

class PiutangController extends Controller
{
    public function index()
    {
        $piutangs = Piutang::orderBy('tanggal_japo','asc')->get();
        // $piutangs = Piutang::where('status','Belum Lunas')->orderBy('tanggal_japo','asc')->get();

        $title = 'Pembayaran Piutang';
        $text = "Yakin uang sudah diterima?";
        confirmDelete($title, $text);

        return view('piutang.index', compact(['piutangs']));
    }

    public function update(Request $request, $id)
    {
        $piutang = Piutang::find($id);
        $piutang->status = 'Lunas';
        $piutang->update();

        return redirect()->route('piutang.index')->withSuccess('Pembayaran sudah diterima!');
    }
    
}