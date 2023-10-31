<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class CetakNotaController extends Controller
{
    public function nota1(Request $request, $id)
    {
    
        $cetakTanggal = $request->input('cetakTanggal');
        $penjualanData = Penjualan::findOrFail($id);

        if ($penjualanData) {
            $detailPenjualanData = DetailPenjualan::where('penjualan_id', $penjualanData->id)
                ->with('barang') // Eager load data barang
                ->get();

            // Load data pelanggan
            $penjualanData->load('pelanggan');

            $pdf = Pdf::loadView('invoice', compact('penjualanData', 'detailPenjualanData'));
            // return $pdf->download($penjualanData->nota_penjualan.'.pdf');
            $pdf->setPaper('A4', 'portrait'); // Atur ukuran dan orientasi kertas

            $output = $pdf->output();

            return view('invoice.format_1', compact('penjualanData', 'detailPenjualanData', 'cetakTanggal'));
        } else {
            // Handle jika penjualan tidak ditemukan
        }
    }

    public function nota2(Request $request, $id)
    {
    
        $cetakTanggal = $request->input('cetakTanggal');
        $penjualanData = Penjualan::findOrFail($id);

        if ($penjualanData) {
            $detailPenjualanData = DetailPenjualan::where('penjualan_id', $penjualanData->id)
                ->with('barang') // Eager load data barang
                ->get();

            // Load data pelanggan
            $penjualanData->load('pelanggan');

            $pdf = Pdf::loadView('invoice', compact('penjualanData', 'detailPenjualanData'));
            // return $pdf->download($penjualanData->nota_penjualan.'.pdf');
            $pdf->setPaper('A4', 'portrait'); // Atur ukuran dan orientasi kertas

            $output = $pdf->output();

            return view('invoice.format_2', compact('penjualanData', 'detailPenjualanData', 'cetakTanggal'));
        } else {
            // Handle jika penjualan tidak ditemukan
        }
    }

    public function nota3(Request $request, $id)
    {
    
        $cetakTanggal = $request->input('cetakTanggal');
        $penjualanData = Penjualan::findOrFail($id);

        if ($penjualanData) {
            $detailPenjualanData = DetailPenjualan::where('penjualan_id', $penjualanData->id)
                ->with('barang') // Eager load data barang
                ->get();

            // Load data pelanggan
            $penjualanData->load('pelanggan');

            $pdf = Pdf::loadView('invoice', compact('penjualanData', 'detailPenjualanData'));
            // return $pdf->download($penjualanData->nota_penjualan.'.pdf');
            $pdf->setPaper('A4', 'portrait'); // Atur ukuran dan orientasi kertas

            $output = $pdf->output();

            return view('invoice.format_3', compact('penjualanData', 'detailPenjualanData', 'cetakTanggal'));
        } else {
            // Handle jika penjualan tidak ditemukan
        }
    }
}