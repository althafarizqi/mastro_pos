@extends('layouts/dashboard')

@section('title')
Laporan Hutang
@endsection


@section('content')

<form action="{{ route('laporan.piutang') }}" method="get">
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
</form>

<table class="table table-responsive-sm table-hover">
    <thead>

        <tr>
            <th>#</th>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $piutang)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$piutang->nota_penjualan}}</td>
            <td>{{$piutang->nama_pelanggan}}</td>
            <td>{{$piutang->tanggal_japo}}</td>
            <td>{{$piutang->status}}</td>
            <td class="text-right">{{formatRupiah($piutang->jumlah_piutang)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="bg-secondary">
            <th></th>
            <th></th>
            <th></th>

            <th colspan="2">
                <h4 class="text-right">Total Piutang :</h4>
            </th>
            <th colspan="5">
                <h4 class="text-right">{{formatRupiah($totalPiutang)}}</h4>
            </th>
            <th></th>
        </tr>
    </tfoot>
</table>

@endsection