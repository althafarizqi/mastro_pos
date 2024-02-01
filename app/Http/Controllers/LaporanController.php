<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Hutang;
use App\Models\Suplier;
use App\Models\Pelanggan;
use App\Models\Piutang;

class LaporanController extends Controller
{
    public function hutang(Request $request)
    {
        $suplier_id = $request->input('suplierId');
        $supliers = Suplier::all();

        $laporans = Hutang::orderBy('tanggal_japo','asc')->get();
        // $totalHutang = Hutang::select(DB::raw('SUM(jumlah_hutang) AS total_hutang'));

        $results = Hutang::leftJoin('pembelians', 'pembelians.id', '=', 'hutangs.pembelian_id')
            ->leftJoin('supliers', 'hutangs.suplier_id', '=', 'supliers.id')
            ->select('hutangs.id','hutangs.jumlah_hutang', 'hutangs.tanggal_japo', 'hutangs.status', 'pembelians.nota_beli', 'pembelians.tanggal', 'supliers.nama AS nama_suplier')
            ->where('hutangs.status', 'Belum Lunas');

            if ($suplier_id !== null) {
            $results->where('supliers.id', $suplier_id);
            }

            // Tambahkan filter berdasarkan tanggal awal dan tanggal akhir
            $tanggal_awal = $request->input('tanggal_awal');
            $tanggal_akhir = $request->input('tanggal_akhir');

            if ($tanggal_awal && $tanggal_akhir) {
                $results->whereBetween('pembelians.tanggal', [$tanggal_awal, $tanggal_akhir]);
            }

            $results = $results->paginate(10);
            $totalHutang = $results->sum('jumlah_hutang');

        return view('hutang.laporan', compact('laporans', 'supliers', 'suplier_id', 'totalHutang', 'results'));
    }

    public function piutang(Request $request)
    {
        $pelanggan_id = $request->input('pelangganId');
        $pelanggans = Pelanggan::all();

        $laporans = Piutang::orderBy('tanggal_japo','asc')->get();
        
        $results = Piutang::leftJoin('penjualans', 'penjualans.id', '=', 'piutangs.penjualan_id')
            ->leftJoin('pelanggans', 'piutangs.pelanggan_id', '=', 'pelanggans.id')
            ->select('piutangs.id','piutangs.jumlah_piutang', 'piutangs.tanggal_japo', 'piutangs.status', 'penjualans.nota_penjualan', 'penjualans.tanggal', 'pelanggans.nama AS nama_pelanggan')
            ->where('piutangs.status', 'Belum Lunas');

            if ($pelanggan_id !== null) {
            $results->where('pelanggans.id', $pelanggan_id);
            }

            // Tambahkan filter berdasarkan tanggal awal dan tanggal akhir
            $tanggal_awal = $request->input('tanggal_awal');
            $tanggal_akhir = $request->input('tanggal_akhir');

            if ($tanggal_awal && $tanggal_akhir) {
                $results->whereBetween('pembelians.tanggal', [$tanggal_awal, $tanggal_akhir]);
            }

            $results = $results->paginate(10);
            $totalPiutang = $results->sum('jumlah_piutang');

        return view('piutang.laporan', compact('laporans', 'pelanggans', 'pelanggan_id', 'totalPiutang', 'results'));
    }
}