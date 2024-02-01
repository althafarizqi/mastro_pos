<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\DetailPenjualan;

class HistoryBarangController extends Controller
{
    public function index(Request $request)
    {
        $barangs = Barang::all();
        $pelanggans = Pelanggan::all();

        $barangId = $request->input('barangId');
        $pelangganId = $request->input('pelangganId');

        $results = DetailPenjualan::leftJoin('penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
            ->leftJoin('pelanggans', 'penjualans.pelanggan_id', '=', 'pelanggans.id')
            ->leftJoin('barangs', 'detail_penjualans.barang_id', '=', 'barangs.id')
            ->select('penjualans.tanggal', 'pelanggans.nama AS nama_pelanggan', 'barangs.nama AS nama_barang', 'detail_penjualans.harga_satuan');
            
            if ($barangId != null) {
                $results->where('barangs.id', $barangId);
            }

            if ($pelangganId != null) {
                $results->where('pelanggans.id', $pelangganId);
            }

            $history = $results->get();

        return view('penjualan.history_barang', compact('barangs', 'pelanggans', 'history'));
    }
}