<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\DetailPembelian;

class LabaRugiController extends Controller
{
    // public function index()
    // {
    //     $barangs = Barang::all();

    //         $data = Barang::select([
    //                 'barangs.id as barang_id',
    //                 'barangs.nama as nama_barang',
    //                 DB::raw('COALESCE(penjualan.total_penjualan, 0) AS total_penjualan'),
    //                 DB::raw('COALESCE(penjualan.rata_rata_harga_penjualan, 0) AS rata_rata_harga_penjualan'),
    //                 DB::raw('COALESCE(pembelian.rata_rata_harga_pembelian, 0) AS rata_rata_harga_pembelian'),
    //                 DB::raw('COALESCE(penjualan.total_pendapatan_penjualan, 0) AS total_pendapatan_penjualan'),
    //                 DB::raw('COALESCE(penjualan.total_penjualan, 0) * COALESCE(pembelian.rata_rata_harga_pembelian, 0) AS harga_pokok'),
    //                 DB::raw('COALESCE(penjualan.total_pendapatan_penjualan, 0) - COALESCE(penjualan.total_penjualan * COALESCE(pembelian.rata_rata_harga_pembelian, 0), 0) AS laba_rugi'),
    //             ])
    //             ->leftJoin(DB::raw('(SELECT barang_id, SUM(jumlah) AS total_penjualan, AVG(harga_satuan) AS rata_rata_harga_penjualan, SUM(jumlah * harga_satuan) AS total_pendapatan_penjualan FROM detail_penjualans GROUP BY barang_id) AS penjualan'), 'barangs.id', '=', 'penjualan.barang_id')
    //             ->leftJoin(DB::raw('(SELECT barang_id, AVG(harga_satuan) AS rata_rata_harga_pembelian FROM detail_pembelians GROUP BY barang_id) AS pembelian'), 'barangs.id', '=', 'pembelian.barang_id')
    //             ->get();
    //             return view('laba_rugi', compact('data', 'barangs'));
    //     }

    public function index(Request $request)
    {
        $barangs = Barang::all();
        $barangId = $request->input('barangId');
        $periodeBulan = $request->input('periodeBulan');
        $currentYear = $request->input('periodeTahun');

        // Pengecekan apakah $barangId memiliki nilai
        if ($barangId) {
            $data = Barang::select([
                    'barangs.id as barang_id',
                    'barangs.nama as nama_barang',
                    DB::raw('COALESCE(penjualan.total_penjualan, 0) AS total_penjualan'),
                    DB::raw('COALESCE(penjualan.rata_rata_harga_penjualan, 0) AS rata_rata_harga_penjualan'),
                    DB::raw('COALESCE(pembelian.rata_rata_harga_pembelian, 0) AS rata_rata_harga_pembelian'),
                    DB::raw('COALESCE(penjualan.total_pendapatan_penjualan, 0) AS total_pendapatan_penjualan'),
                    DB::raw('COALESCE(penjualan.total_penjualan, 0) * COALESCE(pembelian.rata_rata_harga_pembelian, 0) AS harga_pokok'),
                    DB::raw('COALESCE(penjualan.total_pendapatan_penjualan, 0) - COALESCE(penjualan.total_penjualan * COALESCE(pembelian.rata_rata_harga_pembelian, 0), 0) AS laba_rugi'),
                ])
                ->leftJoin(DB::raw('(SELECT barang_id, SUM(jumlah) AS total_penjualan, AVG(harga_satuan) AS rata_rata_harga_penjualan, SUM(jumlah * harga_satuan) AS total_pendapatan_penjualan FROM detail_penjualans WHERE barang_id = '.$barangId.' GROUP BY barang_id) AS penjualan'), 'barangs.id', '=', 'penjualan.barang_id')
                ->leftJoin(DB::raw('(SELECT barang_id, AVG(harga_satuan) AS rata_rata_harga_pembelian FROM detail_pembelians WHERE barang_id = '.$barangId.' GROUP BY barang_id) AS pembelian'), 'barangs.id', '=', 'pembelian.barang_id')
                ->where('barangs.id', $barangId)
                ->get();
                // ->leftJoin(DB::raw('(SELECT barang_id, SUM(jumlah) AS total_penjualan, AVG(harga_satuan) AS rata_rata_harga_penjualan, SUM(jumlah * harga_satuan) AS total_pendapatan_penjualan FROM detail_penjualans WHERE barang_id = ' . $barangId . ' AND MONTH(created_at) = ' . $periodeBulan . ' GROUP BY barang_id) AS penjualan'), 'barangs.id', '=', 'penjualan.barang_id')
                // ->leftJoin(DB::raw('(SELECT barang_id, AVG(harga_satuan) AS rata_rata_harga_pembelian FROM detail_pembelians WHERE barang_id = ' . $barangId . ' AND MONTH(created_at) = ' . $periodeBulan . ' GROUP BY barang_id) AS pembelian'), 'barangs.id', '=', 'pembelian.barang_id')
                // ->where('barangs.id', $barangId)
                // ->get();
        } else if ($periodeBulan){
            // Jika tidak ada $barangId yang dipilih, ambil data laba rugi untuk semua barang
            $data = Barang::select([
                    'barangs.id as barang_id',
                    'barangs.nama as nama_barang',
                    DB::raw('COALESCE(penjualan.total_penjualan, 0) AS total_penjualan'),
                    DB::raw('COALESCE(penjualan.rata_rata_harga_penjualan, 0) AS rata_rata_harga_penjualan'),
                    DB::raw('COALESCE(pembelian.rata_rata_harga_pembelian, 0) AS rata_rata_harga_pembelian'),
                    DB::raw('COALESCE(penjualan.total_pendapatan_penjualan, 0) AS total_pendapatan_penjualan'),
                    DB::raw('COALESCE(penjualan.total_penjualan, 0) * COALESCE(pembelian.rata_rata_harga_pembelian, 0) AS harga_pokok'),
                    DB::raw('COALESCE(penjualan.total_pendapatan_penjualan, 0) - COALESCE(penjualan.total_penjualan * COALESCE(pembelian.rata_rata_harga_pembelian, 0), 0) AS laba_rugi'),
                ])
                // ->leftJoin(DB::raw('(SELECT barang_id, SUM(jumlah) AS total_penjualan, AVG(harga_satuan) AS rata_rata_harga_penjualan, SUM(jumlah * harga_satuan) AS total_pendapatan_penjualan FROM detail_penjualans GROUP BY barang_id) AS penjualan'), 'barangs.id', '=', 'penjualan.barang_id')
                // ->leftJoin(DB::raw('(SELECT barang_id, AVG(harga_satuan) AS rata_rata_harga_pembelian FROM detail_pembelians GROUP BY barang_id) AS pembelian'), 'barangs.id', '=', 'pembelian.barang_id')
                // ->get();

                // ->leftJoin(DB::raw('(SELECT barang_id, SUM(jumlah) AS total_penjualan, AVG(harga_satuan) AS rata_rata_harga_penjualan, SUM(jumlah * harga_satuan) AS total_pendapatan_penjualan FROM detail_penjualans WHERE MONTH(created_at) = ' . $periodeBulan . ' GROUP BY barang_id) AS penjualan'), 'barangs.id', '=', 'penjualan.barang_id')
                // ->leftJoin(DB::raw('(SELECT barang_id, AVG(harga_satuan) AS rata_rata_harga_pembelian FROM detail_pembelians WHERE MONTH(created_at) = ' . $periodeBulan . ' GROUP BY barang_id) AS pembelian'), 'barangs.id', '=', 'pembelian.barang_id')
                // ->get();

                ->leftJoin(DB::raw('(SELECT barang_id, SUM(jumlah) AS total_penjualan, AVG(harga_satuan) AS rata_rata_harga_penjualan, SUM(jumlah * harga_satuan) AS total_pendapatan_penjualan FROM detail_penjualans WHERE MONTH(created_at) = ' . $periodeBulan . ' AND YEAR(created_at) = ' . $currentYear . ' GROUP BY barang_id) AS penjualan'), 'barangs.id', '=', 'penjualan.barang_id')
                ->leftJoin(DB::raw('(SELECT barang_id, AVG(harga_satuan) AS rata_rata_harga_pembelian FROM detail_pembelians WHERE MONTH(created_at) = ' . $periodeBulan . ' AND YEAR(created_at) = ' . $currentYear . ' GROUP BY barang_id) AS pembelian'), 'barangs.id', '=', 'pembelian.barang_id')
                ->get();
        } else {
            $data = Barang::select([
                    'barangs.id as barang_id',
                    'barangs.nama as nama_barang',
                    DB::raw('COALESCE(penjualan.total_penjualan, 0) AS total_penjualan'),
                    DB::raw('COALESCE(penjualan.rata_rata_harga_penjualan, 0) AS rata_rata_harga_penjualan'),
                    DB::raw('COALESCE(pembelian.rata_rata_harga_pembelian, 0) AS rata_rata_harga_pembelian'),
                    DB::raw('COALESCE(penjualan.total_pendapatan_penjualan, 0) AS total_pendapatan_penjualan'),
                    DB::raw('COALESCE(penjualan.total_penjualan, 0) * COALESCE(pembelian.rata_rata_harga_pembelian, 0) AS harga_pokok'),
                    DB::raw('COALESCE(penjualan.total_pendapatan_penjualan, 0) - COALESCE(penjualan.total_penjualan * COALESCE(pembelian.rata_rata_harga_pembelian, 0), 0) AS laba_rugi'),
                ])
                ->leftJoin(DB::raw('(SELECT barang_id, SUM(jumlah) AS total_penjualan, AVG(harga_satuan) AS rata_rata_harga_penjualan, SUM(jumlah * harga_satuan) AS total_pendapatan_penjualan FROM detail_penjualans GROUP BY barang_id) AS penjualan'), 'barangs.id', '=', 'penjualan.barang_id')
                ->leftJoin(DB::raw('(SELECT barang_id, AVG(harga_satuan) AS rata_rata_harga_pembelian FROM detail_pembelians GROUP BY barang_id) AS pembelian'), 'barangs.id', '=', 'pembelian.barang_id')
                ->get();
        }

        $grandTotalPendapatan=$data->sum('total_pendapatan_penjualan');
        $grandTotalHpp=$data->sum('harga_pokok');
        $grandTotalLaba=$data->sum('laba_rugi');
        return view('laba_rugi', compact('data', 'barangs', 'grandTotalPendapatan', 'grandTotalHpp', 'grandTotalLaba'));
    }


}
