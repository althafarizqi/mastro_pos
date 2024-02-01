<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Piutang;
use Illuminate\Support\Carbon;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan_id = $request->input('pelangganId');
        $pelanggans = Pelanggan::all();

        $totalPenjualan = Penjualan::select(DB::raw('SUM(total_harga) AS total_penjualan'));

        $results = Penjualan::leftJoin('piutangs', 'penjualans.id', '=', 'piutangs.penjualan_id')
            ->leftJoin('pelanggans', 'penjualans.pelanggan_id', '=', 'pelanggans.id')
            ->select('penjualans.id','penjualans.tanggal', 'penjualans.nota_penjualan', 'penjualans.pembayaran', 'penjualans.total_harga', 'pelanggans.nama AS nama_pelanggan',
                DB::raw('IFNULL(piutangs.status, "Lunas") AS status')
            );


        if ($pelanggan_id !== null) {
            $results->where('pelanggans.id', $pelanggan_id);
            $totalPenjualan->where('penjualans.pelanggan_id', $pelanggan_id);
        }

        // Tambahkan filter berdasarkan tanggal awal dan tanggal akhir
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        if ($tanggal_awal && $tanggal_akhir) {
            $results->whereBetween('penjualans.tanggal', [$tanggal_awal, $tanggal_akhir]);
            $totalPenjualan->whereBetween('penjualans.tanggal', [$tanggal_awal, $tanggal_akhir]);
        }

        $results = $results->get();
        $totalPenjualan = $totalPenjualan->get();

        
            // dd($results);

        return view('penjualan.index', compact(['results', 'pelanggan_id', 'pelanggans', 'tanggal_awal', 'tanggal_akhir', 'totalPenjualan']));
    }
    public function create()
    {
        $now = Carbon::now();
        $thnBulan = $now->year . sprintf("%02d", $now->month);

        $lastSale = Penjualan::latest('created_at')->first();

        if ($lastSale && $lastSale->created_at->format('Ym') == $thnBulan) {
            // Jika bulan dan tahun terakhir sama dengan bulan dan tahun saat ini
            $urut = (int)substr($lastSale->nota_penjualan, -4) + 1;
        } else {
            // Jika berbeda, mulai dari urutan 1
            $urut = 1;
        }

        $nomor = 'INV' . $thnBulan . sprintf("%04d", $urut);


        $pelanggans = Pelanggan::orderBy('nama','asc')->get();
        $barangs = Barang::orderBy('kategori_id','asc')->get();

        return view('penjualan.create', compact(['pelanggans', 'barangs', 'nomor']));


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
            // $pajak = $request->pajak;
            // $diskon = $request->diskon;
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
            // $pajak = $request->pajak;
            // $diskon = $request->diskon;
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
            
                // Perbaharui stok
                $barang = Barang::find($barang_id);
                dd($barang);
                $barang->stok -= $jumlahs[$key];
                $barang->save();
            }

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

    public function edit($id)
    {
        $penjualanData = Penjualan::findOrFail($id);
        
        if ($penjualanData) {
            $detailPenjualanData = DetailPenjualan::where('penjualan_id', $penjualanData->id)
                ->with('barang') // Eager load data barang
                ->get();

            // Load data pelanggan
            $penjualanData->load('pelanggan');

            $barangs = Barang::orderBy('kategori_id','asc')->get();

            return view('penjualan.edit', compact('penjualanData', 'detailPenjualanData', 'barangs'));
        } 
    }

    public function update(Request $request, $id)
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

        // Ambil data penjualan yang akan diubah
        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return redirect('/')->with('error', 'Data penjualan tidak ditemukan');
        }

        // Cek apakah metode pembayaran berubah
        if ($request->pembayaran != $penjualan->pembayaran) {
            // Metode pembayaran berubah, perlu menghapus atau memperbarui data piutang
            if ($penjualan->pembayaran == 'Tempo') {
                // Hapus data piutang jika sebelumnya menggunakan 'Tempo'
                Piutang::where('penjualan_id', $penjualan->id)->delete();
            } elseif ($request->pembayaran == 'Tempo') {
                // Buat catatan piutang jika sekarang menggunakan 'Tempo'
                $piutang = new Piutang;
                $piutang->penjualan_id = $penjualan->id;
                $piutang->pelanggan_id = $penjualan->pelanggan_id;
                $piutang->jumlah_piutang = $request->total_harga;
                $piutang->tanggal_japo = $request->tanggal_japo;
                $piutang->status = 'Belum Lunas';
                $piutang->save();
            }
        }

        // Kemudian, perbarui data penjualan seperti yang Anda lakukan dalam metode 'store'
        $penjualan->tanggal = $request->tanggal;
        $penjualan->nota_penjualan = $request->nota_penjualan;
        $penjualan->pelanggan_id = $request->pelanggan_id;
        $penjualan->pembayaran = $request->pembayaran;
        $penjualan->tanggal_japo = $request->tanggal_japo;
        $penjualan->pajak = $request->pajak;
        $penjualan->diskon = $request->diskon;
        $penjualan->total_harga = $request->total_harga;
        $penjualan->save();

        // Loop melalui array dan perbarui atau tambahkan detail penjualan
        foreach ($request->barang_id as $key => $barang_id) {
            $existingDetail = DetailPenjualan::where('penjualan_id', $penjualan->id)
                ->where('barang_id', $barang_id)
                ->first();

            $jumlah = $request->jumlah[$key]; // Jumlah baru dari permintaan

            if ($existingDetail) {
                $jumlah_lama = $existingDetail->jumlah; // Jumlah lama
                if ($jumlah != $jumlah_lama) {
                    // Jumlah berubah, perbarui data yang ada dan stok barang
                    $existingDetail->jumlah = $jumlah;
                    $existingDetail->harga_satuan = $request->harga_satuan[$key];
                    $existingDetail->subtotal_harga = $request->subtotal_harga[$key];
                    $existingDetail->save();

                    // Perbarui stok barang sesuai dengan logika Anda
                    $diff = $jumlah_lama - $jumlah;
                    $barang = Barang::find($barang_id);
                    $barang->stok += $diff;
                    $barang->save();
                } else {
                    // Jumlah tidak berubah, hanya perbarui data yang ada
                    $existingDetail->harga_satuan = $request->harga_satuan[$key];
                    $existingDetail->subtotal_harga = $request->subtotal_harga[$key];
                    $existingDetail->save();
                }
            } else {
                // Detail penjualan belum ada, buat data baru dan kurangi stok barang
                $detailpenjualan = new DetailPenjualan;
                $detailpenjualan->penjualan_id = $penjualan->id;
                $detailpenjualan->barang_id = $barang_id;
                $detailpenjualan->jumlah = $jumlah;
                $detailpenjualan->harga_satuan = $request->harga_satuan[$key];
                $detailpenjualan->subtotal_harga = $request->subtotal_harga[$key];
                $detailpenjualan->save();

                // Kurangi stok barang sesuai dengan logika Anda
                $barang = Barang::find($barang_id);
                $diff = $jumlah; // Untuk barang baru, stok kurang sama dengan jumlah
                $barang->stok -= $diff;
                $barang->save();
            }
        }

        // Redirect atau melakukan tindakan lain setelah berhasil memperbarui
        return redirect('/')->with('success', 'Data penjualan berhasil diperbarui');
    }

}