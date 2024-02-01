<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\ReturPenjualan;
use App\Models\DetailReturPenjualan;
use App\Models\Barang;
use App\Models\Piutang;

class ReturPenjualanController extends Controller
{
    public function index(Request $request)
    {   
        try {
            $nomorNota = $request->input('nomorNota');
            $penjualanData = Penjualan::where('nota_penjualan', 'INV'.$nomorNota)->first();
            $detailPenjualanData = [];

            if ($penjualanData) {
                $detailPenjualanData = DetailPenjualan::where('penjualan_id', $penjualanData->id)
                    ->with('barang') // Eager load data barang
                    ->get();
                // Load data pelanggan
                $penjualanData->load('pelanggan');
            }
            // dd($penjualanData);
            return view('penjualan.retur_penjualan', compact('penjualanData', 'detailPenjualanData'));
        } catch (\Throwable $th) {
        }
        
    }

    public function copyto(Request $request, $inv)
    {
        // Retrieve data penjualan based on nota_penjualan
        $penjualanData = Penjualan::where('nota_penjualan', $inv)->first();

        if (!$penjualanData) {
            return redirect()->back()->with('error', 'Penjualan record not found.');
        }

        // Check if the payment is due
        if ($penjualanData->pembayaran == 'Tempo') {
            // Delete associated Piutang records
            $piutangData = Piutang::where('penjualan_id', $penjualanData->id)->get();
            foreach ($piutangData as $piutang) {
                $piutang->delete();
            }
        }

        // Retrieve detail penjualan based on penjualan_id
        $detailPenjualanData = DetailPenjualan::where('penjualan_id', $penjualanData->id)->get();

        // Duplicate data to ReturPenjualan
        $returPenjualan = ReturPenjualan::create($penjualanData->toArray());

        // Duplicate data to DetailReturPenjualan and update barang stok
        foreach ($detailPenjualanData as $detailPenjualan) {
            // Duplicate data to DetailReturPenjualan
            $returDetail = DetailReturPenjualan::create($detailPenjualan->toArray());

            // Update barang stok
            $barang = Barang::find($detailPenjualan->barang_id);

            if ($barang) {
                // Increment the stok based on the quantity returned
                $barang->update(['stok' => $barang->stok + $returDetail->jumlah]);
            }
        }

        // Soft delete original data
        $penjualanData->delete();
        $detailPenjualanData->each->delete();

        // Redirect or do something else after copying
        return redirect()->route('returpenjualan.index');
    }

    // public function copyto(Request $request, $inv)
    // {
    //     // Retrieve data penjualan based on nota_penjualan
    //     $penjualanData = Penjualan::where('nota_penjualan', $inv)->first();

    //     if (!$penjualanData) {
    //         return redirect()->back()->with('error', 'Penjualan record not found.');
    //     }

    //     // Retrieve detail penjualan based on penjualan_id
    //     $detailPenjualanData = DetailPenjualan::where('penjualan_id', $penjualanData->id)->get();

    //     // Duplicate data to ReturPenjualan
    //     $returPenjualan = ReturPenjualan::create($penjualanData->toArray());

    //     // Duplicate data to DetailReturPenjualan and update barang stok
    //     foreach ($detailPenjualanData as $detailPenjualan) {
    //         // Duplicate data to DetailReturPenjualan
    //         $returDetail = DetailReturPenjualan::create($detailPenjualan->toArray());

    //         // Update barang stok
    //         $barang = Barang::find($detailPenjualan->barang_id);

    //         if ($barang) {
    //             // Increment the stok based on the quantity returned
    //             $barang->update(['stok' => $barang->stok + $returDetail->jumlah]);
    //         }
    //     }

    //     // Soft delete original data
    //     $penjualanData->delete();
    //     $detailPenjualanData->each->delete();

    //     // Redirect or do something else after copying
    //     return redirect()->route('returpenjualan.index');
    // }
}