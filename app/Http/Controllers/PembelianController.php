<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Suplier;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Hutang;


class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $supliers = Suplier::orderBy('nama','asc')->get();
        $suplier_id = $request->input('suplierId');

        // $pembelians = Pembelian::orderBy('tanggal','asc')->get();

        $totalPembelian = Pembelian::select(DB::raw('SUM(total_harga) AS total_pembelian'));

        $results = DB::table('pembelians')
            ->leftJoin('hutangs', 'pembelians.id', '=', 'hutangs.pembelian_id')
            ->leftJoin('supliers', 'pembelians.suplier_id', '=', 'supliers.id')
            ->select('pembelians.*', 'supliers.nama AS nama_suplier', DB::raw('IFNULL(hutangs.status, "Lunas") AS status'));
            
            if ($suplier_id !== null) {
            $results->where('supliers.id', $suplier_id);
            $totalPembelian->where('pembelians.suplier_id', $suplier_id);
        }

        // Tambahkan filter berdasarkan tanggal awal dan tanggal akhir
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        if ($tanggal_awal && $tanggal_akhir) {
            $results->whereBetween('pembelians.tanggal', [$tanggal_awal, $tanggal_akhir]);
            $totalPembelian->whereBetween('pembelians.tanggal', [$tanggal_awal, $tanggal_akhir]);
        }

        $results = $results->get();
        $totalPembelian = $totalPembelian->get();

        return view('pembelian.index', compact(['results', 'supliers', 'suplier_id', 'totalPembelian']));
    }

    public function create()
    {
        $supliers = Suplier::orderBy('nama','asc')->get();
        $barangs = Barang::orderBy('kategori_id','asc')->get();
        return view('pembelian.create', compact(['supliers','barangs']));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tanggal' => 'required',
            'nota_beli' => 'required',
            'suplier_id' => 'required',
            'pembayaran' => 'required|in:Tunai,Tempo',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
            'harga_satuan' => 'required|array',
            'subtotal_harga' => 'required|array',
            'total_harga' => 'required'
        ]);

        $tanggal = $request->tanggal;
        $nota_beli = $request->nota_beli;
        $suplier_id = $request->suplier_id;
        $pembayaran = $request->pembayaran;
        $tanggal_japo = $request->tanggal_japo;
        $total_harga = $request->total_harga;

        $barang_ids = $request->barang_id;
        $jumlahs = $request->jumlah;
        $harga_satuans = $request->harga_satuan;
        $subtotal_hargas = $request->subtotal_harga;

        $pembelian = new Pembelian;
        $pembelian->tanggal = $tanggal;
        $pembelian->nota_beli = $nota_beli;
        $pembelian->suplier_id = $suplier_id;
        $pembelian->pembayaran = $pembayaran;
        $pembelian->tanggal_japo = $tanggal_japo;
        $pembelian->total_harga = $total_harga;
        $pembelian->save();

        // Loop melalui array dan simpan setiap item pembelian
        foreach ($barang_ids as $key => $barang_id) {
            $detailpembelian = new DetailPembelian;
            $detailpembelian->pembelian_id = $pembelian->id;
            $detailpembelian->barang_id = $barang_id; // Setel 'barang_id' untuk objek detailpembelian
            $detailpembelian->jumlah = $jumlahs[$key];
            $detailpembelian->harga_satuan = $request->harga_satuan[$key];
            $detailpembelian->subtotal_harga = $request->subtotal_harga[$key];
            $detailpembelian->save();
        }

        // Perbarui stok barang
        foreach ($barang_ids as $key => $barang_id) {
            $barang = Barang::find($barang_id);
            $barang->stok += $jumlahs[$key];
            $barang->save();
        }

        // Input ke Tabel Hutang
        if ($request->pembayaran == 'Tempo') {
        $hutang = new Hutang;
        $hutang->pembelian_id = $pembelian->id;
        $hutang->suplier_id = $suplier_id;
        $hutang->jumlah_hutang = $total_harga;
        $hutang->tanggal_japo = $tanggal_japo;
        $hutang->status = 'Belum Lunas';
        $hutang->save();
    }

        // Redirect atau melakukan tindakan lain setelah berhasil menyimpan
        return redirect('/pembelian/create')->with('success', 'Data pembelian berhasil disimpan');
    }
}