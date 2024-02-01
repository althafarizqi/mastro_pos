<?php

namespace App\Http\Controllers;

use App\Exports\ExportLabaRugi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\DetailPembelian;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class LabaRugiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // $results = Penjualan::leftJoin('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
        //     ->leftJoin('pelanggans', 'penjualans.pelanggan_id', '=', 'pelanggans.id')
        //     ->leftJoin('barangs AS barang_penjualan', 'detail_penjualans.barang_id', '=', 'barang_penjualan.id')
        //     ->leftJoin('detail_pembelians', function ($join) {
        //         $join->on('detail_penjualans.barang_id', '=', 'detail_pembelians.barang_id')
        //             ->groupBy('detail_penjualans.barang_id');
        //     })
        //     ->leftJoin('barangs AS barang_pembelian', 'detail_pembelians.barang_id', '=', 'barang_pembelian.id')
        //     ->select(
        //         'penjualans.id', // tambahkan id penjualan ke dalam SELECT
        //         'penjualans.tanggal',
        //         'penjualans.nota_penjualan',
        //         'penjualans.total_harga',
        //         'pelanggans.nama AS nama_pelanggan',
        //         'barang_penjualan.nama AS nama_barang_penjualan',
        //         'detail_penjualans.jumlah',
        //         'detail_penjualans.subtotal_harga AS harga_satuan_penjualan',
        //         DB::raw('SUM(detail_pembelians.jumlah) AS total_pembelian, SUM(detail_pembelians.subtotal_harga) AS harga_satuan_pembelian')
        //     )
        //     ->groupBy('penjualans.id', 'penjualans.tanggal', 'penjualans.nota_penjualan', 'penjualans.total_harga', 'pelanggans.nama', 'barang_penjualan.nama', 'detail_penjualans.jumlah', 'detail_penjualans.subtotal_harga'); // tambahkan semua kolom yang muncul di SELECT ke dalam GROUP BY

        // if ($tanggal_awal && $tanggal_akhir) {
        //     $results->whereBetween('penjualans.tanggal', [$tanggal_awal, $tanggal_akhir]);
        // }

        // $results = $results->get();

        $results = Penjualan::leftJoin('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
            ->leftJoin('pelanggans', 'penjualans.pelanggan_id', '=', 'pelanggans.id')
            ->leftJoin('barangs AS barang_penjualan', 'detail_penjualans.barang_id', '=', 'barang_penjualan.id')
            ->leftJoin('detail_pembelians', function ($join) {
                $join->on('detail_penjualans.barang_id', '=', 'detail_pembelians.barang_id')
                    ->groupBy('detail_penjualans.barang_id');
            })
            ->leftJoin('barangs AS barang_pembelian', 'detail_pembelians.barang_id', '=', 'barang_pembelian.id')
            ->select(
                'penjualans.id', // tambahkan id penjualan ke dalam SELECT
                'penjualans.tanggal',
                'penjualans.nota_penjualan',
                'penjualans.total_harga',
                'pelanggans.nama AS nama_pelanggan',
                'barang_penjualan.nama AS nama_barang_penjualan',
                'detail_penjualans.jumlah',
                'detail_penjualans.subtotal_harga AS harga_satuan_penjualan',
                DB::raw('SUM(detail_pembelians.jumlah) AS total_pembelian'), // hitung total_pembelian
                DB::raw('SUM(detail_pembelians.subtotal_harga) AS harga_satuan_pembelian'), // hitung harga_satuan_pembelian
                DB::raw('(SUM(detail_pembelians.subtotal_harga) / NULLIF(SUM(detail_pembelians.jumlah), 0)) AS rasio_harga_pembelian') // hitung rasio harga pembelian
            )
            ->groupBy('penjualans.id', 'penjualans.tanggal', 'penjualans.nota_penjualan', 'penjualans.total_harga', 'pelanggans.nama', 'barang_penjualan.nama', 'detail_penjualans.jumlah', 'detail_penjualans.subtotal_harga'); // tambahkan semua kolom yang muncul di SELECT ke dalam GROUP BY

            if ($tanggal_awal && $tanggal_akhir) {
                $results->whereBetween('penjualans.tanggal', [$tanggal_awal, $tanggal_akhir]);
            }

            $results = $results->get();


        return view('laba_rugi', compact('results', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function exportExcell(Request $request)
    {
        $tanggal_awal = $request->input('tanggalAwal');
        $tanggal_akhir = $request->input('tanggalAkhir');

        $results = Penjualan::leftJoin('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
            ->leftJoin('pelanggans', 'penjualans.pelanggan_id', '=', 'pelanggans.id')
            ->leftJoin('barangs AS barang_penjualan', 'detail_penjualans.barang_id', '=', 'barang_penjualan.id')
            ->leftJoin('detail_pembelians', function ($join) {
                $join->on('detail_penjualans.barang_id', '=', 'detail_pembelians.barang_id')
                    ->groupBy('detail_penjualans.barang_id');
            })
            ->leftJoin('barangs AS barang_pembelian', 'detail_pembelians.barang_id', '=', 'barang_pembelian.id')
            ->select(
                'penjualans.id', // tambahkan id penjualan ke dalam SELECT
                'penjualans.tanggal',
                'penjualans.nota_penjualan',
                'penjualans.total_harga',
                'pelanggans.nama AS nama_pelanggan',
                'barang_penjualan.nama AS nama_barang_penjualan',
                'detail_penjualans.jumlah',
                'detail_penjualans.subtotal_harga AS harga_satuan_penjualan',
                DB::raw('AVG(detail_pembelians.harga_satuan) AS harga_satuan_pembelian')
            )
            ->groupBy('penjualans.id', 'penjualans.tanggal', 'penjualans.nota_penjualan', 'penjualans.total_harga', 'pelanggans.nama', 'barang_penjualan.nama', 'detail_penjualans.jumlah', 'detail_penjualans.subtotal_harga'); // tambahkan semua kolom yang muncul di SELECT ke dalam GROUP BY

        if ($tanggal_awal && $tanggal_akhir) {
            $results->whereBetween('penjualans.tanggal', [$tanggal_awal, $tanggal_akhir]);
        }

        $results = $results->get();

        if ($tanggal_awal && $tanggal_akhir != null) {
            return Excel::download(new ExportLabaRugi($results, $tanggal_awal, $tanggal_akhir), 'LabaRugi_' . Carbon::parse($tanggal_awal)->translatedFormat('dMY') . '_' . Carbon::parse($tanggal_akhir)->translatedFormat('dMY') . '.xlsx');
        } else {
            return Excel::download(new ExportLabaRugi($results, $tanggal_awal, $tanggal_akhir), 'Laba_Rugi_All.xlsx');
        }
    }
}
