@extends('layouts/dashboard')

@section('title')
Laporan Stok
@endsection

@section('content')
<table id="example1" class="table table-striped">
    <thead>
        <tr class="text-center">
            <th>Nama Barang</th>
            <th>Harga Beli</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Retur Jual</th>
            <th>Retur Beli</th>
            <th>Total Stok</th>
            <th>Dalam Rupiah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangs as $barang)
        <tr>
            <td>{{ $barang->nama }}</td>
            <td class="text-right">
                @foreach ($barang->detailpembelian as $detailpembelian)
                {{ formatRupiah($detailpembelian->subtotal_harga/$detailpembelian->masuk) }}
                @endforeach
            </td>
            <td class="text-center">
                @foreach ($barang->detailpembelian as $detailpembelian)
                {{ $detailpembelian->masuk }}
                @endforeach
            </td>
            <td class="text-center">
                @foreach ($barang->detailpenjualan as $detailpenjualan)
                {{ $detailpenjualan->keluar }}
                @endforeach
            </td>
            <td class="text-center">
                @foreach ($barang->detailreturPenjualan as $detailreturPenjualan)
                {{ $detailreturPenjualan->retur }}
                @endforeach
            </td>
            <td class="text-center">
                @foreach ($barang->detailreturPembelian as $detailreturPembelian)
                {{ $detailreturPembelian->retur }}
                @endforeach
            </td>
            <td class="text-center">{{ $barang->stok }}</td>
            <td class="text-center">
                {{ formatRupiah($totalDalamRupiah[$barang->id]) }}
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="text-center bg-secondary">
            <th colspan="7">
                <h4 class="font-weight-bold">Total Stok dalam Rupiah</h4>
            </th>
            <th>
                <h4 class="font-weight-bold">{{ formatRupiah($xyz) }}</h4>
            </th>
        </tr>
    </tfoot>
</table>
@endsection
