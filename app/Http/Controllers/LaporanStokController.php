<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class LaporanStokController extends Controller
{
    public function index()
    {
        $barangs = Barang::has('detailpembelian')->with([
            'detailpembelian' => function ($query) {
                $query->select('barang_id', \DB::raw('SUM(jumlah) as masuk'), \DB::raw('SUM(subtotal_harga) as subtotal_harga'))->groupBy('barang_id');
            },
            'detailpenjualan' => function ($query) {
                $query->select('barang_id', \DB::raw('SUM(jumlah) as keluar'), \DB::raw('MAX(harga_satuan) as harga_satuan'))->groupBy('barang_id');
                $query->withTrashed();
            },
            'detailreturPembelian' => function ($query) {
                $query->select('barang_id', \DB::raw('SUM(jumlah) as retur'), \DB::raw('MAX(harga_satuan) as harga_satuan'))->groupBy('barang_id');
            },
            'detailreturPenjualan' => function ($query) {
                $query->select('barang_id', \DB::raw('SUM(jumlah) as retur'), \DB::raw('MAX(harga_satuan) as harga_satuan'))->groupBy('barang_id');
            },
        ])->get();

        $totalDalamRupiah = [];
        foreach ($barangs as $barang) {
            $detailpembelian = $barang->detailpembelian->first();
            if ($detailpembelian) {
                $dalamRupiah = $barang->stok * $detailpembelian->subtotal_harga/ $detailpembelian->masuk;
                $totalDalamRupiah[$barang->id] = $dalamRupiah;
            }
        }



        $xyz = array_sum($totalDalamRupiah);

        return view('barang.laporan_stok', compact('barangs', 'totalDalamRupiah', 'xyz'));
    }
}
