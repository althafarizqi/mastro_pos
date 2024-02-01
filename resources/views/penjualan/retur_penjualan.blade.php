@extends('layouts/dashboard')

@section('content')
<form action="{{ route('returpenjualan.index') }}" method="get">
    <div class="input-group">

        <input class="form-control" type="number" name="nomorNota">

        <div class="input-group-prepend">
            <button class="form-control btn btn-primary" type="submit">Tampilkan</button>
        </div>
    </div>
</form>

@if($penjualanData !== null)
<form action="{{ route('returpenjualan.copyto', $penjualanData->nota_penjualan) }}" method="post">
    @csrf
    <div class="mt-4 font-weight-bold text-lg">
        <span>Nomor Invoice &nbsp;&nbsp;&nbsp;&nbsp; :</span>&nbsp;<span>{{$penjualanData->nota_penjualan}}</span><br>
        <span>Nama Pelanggan :</span>&nbsp;<span>{{$penjualanData->pelanggan->nama}}</span>
    </div>

    @if(count($detailPenjualanData) > 0)
    <table class="table">
        <thead>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Total</th>
        </thead>
        @foreach($detailPenjualanData as $items)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$items->barang->nama}}</td>
            <td>{{$items->jumlah}}</td>
            <td>{{formatRupiah($items->harga_satuan)}}</td>
            <td>{{formatRupiah($items->subtotal_harga)}}</td>
        </tr>
        @endforeach
        <tfoot>
            <th colspan="3">Jumlah</th>
            <th>{{formatRupiah($penjualanData->total_harga)}}</th>
        </tfoot>
    </table>
    @else
    <p>No detail data available.</p>
    @endif

    <button class="form-control btn btn-danger">Retur</button>
    @else
    <p>Masukkan Nomor Invoice, Contoh : 2023100001</p>
    @endif
</form>
@endsection