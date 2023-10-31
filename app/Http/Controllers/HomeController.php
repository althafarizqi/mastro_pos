<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Piutang;
use App\Models\Hutang;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $thnBulan = $now->year . sprintf("%02d", $now->month);

        $cek = Penjualan::count();
        if ($cek == 0) {
            $urut = 1;
        } else {
            $ambil = Penjualan::latest('created_at')->first();
            $urut = (int)substr($ambil->nota_penjualan, -4) + 1;
        }
        $nomor = 'INV' . $thnBulan . sprintf("%04d", $urut);

        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $penjualans = Penjualan::whereDate('tanggal', $today)->orderBy('nota_penjualan', 'desc')->get();
        $pelanggans = Pelanggan::orderBy('nama','asc')->get();
        $barangs = Barang::orderBy('kategori_id','asc')->get();
        $piutangs = Piutang::orderBy('tanggal_japo','asc')->get();
        // $hutangs = Hutang::orderBy('tanggal_japo','asc')->get();
        $hutangs = Hutang::where('status', 'Belum Lunas')
            ->orderBy('tanggal_japo', 'asc')
            ->get();
        return view('home', compact(['pelanggans','barangs','piutangs','hutangs','penjualans','nomor']));
    }
    
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tanggal' => 'required',
            'nota_penjualan' => 'required',
            'pelanggan_id' => 'required',
            'pembayaran' => 'required|in:Tunai,Tempo',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
            'harga_satuan' => 'required|array',
            'subtotal_harga' => 'required|array',
            'total_harga' => 'required'
        ]);

        $tanggal = $request->tanggal;
        $nota_penjualan = $request->nota_penjualan;
        $pelanggan_id = $request->pelanggan_id;
        $pembayaran = $request->pembayaran;
        $tanggal_japo = $request->tanggal_japo;
        $pajak = $request->pajak;
        $diskon = $request->diskon;
        $total_harga = $request->total_harga;

        $barang_ids = $request->barang_id;
        $jumlahs = $request->jumlah;
        $harga_satuans = $request->harga_satuan;
        $subtotal_hargas =$request->subtotal_harga;

        $penjualan = new Penjualan;
        $penjualan->tanggal = $tanggal;
        $penjualan->nota_penjualan = $nota_penjualan;
        $penjualan->pelanggan_id = $pelanggan_id;
        $penjualan->pembayaran = $pembayaran;
        $penjualan->tanggal_japo = $tanggal_japo;
        $penjualan->diskon = $diskon;
        $penjualan->pajak= $pajak;
        $penjualan->total_harga = $total_harga;
        $penjualan->save();

        // Loop melalui array dan simpan setiap item pembelian
        foreach ($barang_ids as $key => $barang_id) {
            $detailpenjualan = new DetailPenjualan;
            $detailpenjualan->penjualan_id = $penjualan->id;
            $detailpenjualan->barang_id = $barang_id; // Setel 'barang_id' untuk objek detailpenjualan
            $detailpenjualan->jumlah = $jumlahs[$key];
            $detailpenjualan->harga_satuan = $harga_satuans[$key];
            $detailpenjualan->subtotal_harga = $subtotal_hargas[$key];
            $detailpenjualan->save();
        }

        // Perbarui stok barang
        $barang = Barang::find($barang_id);
        $barang->stok -= $jumlahs[$key];
        $barang->save();

        // Input ke Tabel Piutang
        if ($request->pembayaran == 'Tempo') {
        $piutang = new Piutang;
        $piutang->penjualan_id = $penjualan->id;
        $piutang->pelanggan_id = $pelanggan_id;
        $piutang->jumlah_piutang = $total_harga;
        $piutang->tanggal_japo = $tanggal_japo;
        $piutang->status = 'Belum Lunas';
        $piutang->save();
    }

        // Redirect atau melakukan tindakan lain setelah berhasil menyimpan
        return redirect('/')->with('success', 'Data penjualan berhasil disimpan');
    }


    public function show($id)
    {
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

            return view('invoice.format_1', compact('penjualanData', 'detailPenjualanData'));
        } else {
            // Handle jika penjualan tidak ditemukan
        }
    }
}