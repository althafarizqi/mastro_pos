@extends('layouts/dashboard')

@section('title')
Laporan Penjualan
@endsection

@section('btn')
<div class="card-header">
    <form action="{{ route('penjualan.index') }}" method="get">
        <div class="input-group">
            <select name="pelangganId" class="custom-select" id="inputGroupSelect04"
                aria-label="Example select with button addon">
                <option value="">----Pilih Customer----</option>
                @foreach($pelanggans as $pelanggan)
                <option value="{{ $pelanggan->id }}" @if($pelanggan->id == $pelanggan_id) selected @endif>{{
                    $pelanggan->nama }}</option>
                @endforeach
            </select>
            <input type="date" name="tanggal_awal" class="form-control">
            <input type="date" name="tanggal_akhir" class="form-control">
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
        {{-- <div class="input-group">
            <select name="pelangganId" class="custom-select" id="inputGroupSelect04"
                aria-label="Example select with button addon">
                <option value="">----Pilih Customer----</option>
                @foreach($pelanggans as $pelanggan)
                <option value="{{ $pelanggan->id }}" @if($pelanggan->id == $pelanggan_id) selected @endif>{{
                    $pelanggan->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group">
            <input type="date" name="tanggal_awal">
            <input type="date" name="tanggal_akhir">
        </div>
        <div class="input-group">
            <button type="submit">Tampilkan</button>
        </div> --}}
    </form>
</div>
@endsection

@section('content')
<table id="example1" class="table table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>No. Invoice</th>
            <th>Pelanggan</th>
            <th>Pembayaran</th>
            <th>Status</th>
            <th>Total Harga</th>
            <th style="text-align: center">Tanpa<br />Tanggal</th>
            <th>Cetak Nota</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $items)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$items->tanggal}}</td>
            <td>{{$items->nota_penjualan}}</td>
            <td>{{$items->nama_pelanggan}}</td>
            <td>{{$items->pembayaran}}</td>
            <td>{{$items->status}}</td>
            <td class="text-right">{{formatRupiah($items->total_harga)}}</td>
            <td style="text-align: center">
                <form class="form-group" action="cetaknota1/{{$items->id}}" method="get">

                    <input type="hidden" name="cetakTanggal" value="1">
                    <!-- Nilai defaultnya adalah 1 (tercetak) -->
                    <input type="checkbox" name="cetakTanggal" id="cetakTanggal" value="0">
                    <!-- Nilai checkbox 0 (tidak tercetak) -->
            </td>
            <td class="row">
                <form class="form-group" action="cetaknota1/{{$items->id}}" method="get">
                    <button class="btn btn-danger btn-sm mr-1" type="submit">1</button>
                    <button class="btn btn-danger btn-sm mr-1" type="submit"
                        formaction="cetaknota2/{{$items->id}}">2</button>
                    <button class="btn btn-danger btn-sm" type="submit"
                        formaction="cetaknota3/{{$items->id}}">3</button>
                </form>
            </td>
            {{-- <td class="row">
                <a class="btn btn-info btn-sm" href="/penjualan/{{$items->id}}/edit">
                    <i class="fas fa-pencil-alt">
                    </i>

                </a>
                <form action="penjualan/{{$items->id}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <a href="{{ route('penjualan.destroy', $items->id) }}" class="btn btn-danger btn-sm"
                        data-confirm-delete="true">
                        <i class="fas fa-trash">
                        </i>

                    </a>
                </form>
            </td> --}}
        </tr>
        @endforeach
    </tbody>
</table>
<table id="" class="table table-striped dtr-inline">
    <thead>
        <tr class="bg-secondary">
            <td colspan="7" class="text-right">
                <h4>Total Penjualan :</h4>
            </td>
            <td>
                <h4 class="text-center">{{formatRupiah($totalPenjualan->first()->total_penjualan)}}</h4>
            </td>
            <td></td>
            <td></td>
        </tr>
    </thead>
</table>
@endsection