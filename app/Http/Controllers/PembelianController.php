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
    public function index()
    {
        // $pembelians = Pembelian::orderBy('tanggal','asc')->get();
        $results = DB::table('pembelians')
            ->leftJoin('hutangs', 'pembelians.id', '=', 'hutangs.pembelian_id')
            ->leftJoin('supliers', 'pembelians.suplier_id', '=', 'supliers.id')
            ->select('pembelians.*', 'supliers.nama AS nama_suplier', DB::raw('IFNULL(hutangs.status, "Lunas") AS status'))
            ->get();

        return view('pembelian.index', compact(['results']));
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
            'harga' => 'required|array',
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
        $hargas = $request->harga;

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
            $detailpembelian->harga = $hargas[$key];
            $detailpembelian->save();
        }

        // Perbarui stok barang
        $barang = Barang::find($barang_id);
        $barang->stok += $jumlahs[$key];
        $barang->save();

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