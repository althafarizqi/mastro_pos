@extends('layouts/dashboard')

@section('title')
Laporan Hutang
@endsection


@section('content')

<form action="{{ route('laporan.hutang') }}" method="get">
    <div class="input-group">
        <select name="suplierId" class="custom-select" id="inputGroupSelect04"
            aria-label="Example select with button addon">
            <option value="">----Pilih Suplier----</option>
            @foreach($supliers as $suplier)
            <option value="{{ $suplier->id }}" @if($suplier->id == $suplier_id) selected @endif>{{
                $suplier->nama }}</option>
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
            <th>Suplier</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $hutang)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$hutang->nota_beli}}</td>
            <td>{{$hutang->nama_suplier}}</td>
            <td>{{$hutang->tanggal_japo}}</td>
            <td>{{$hutang->status}}</td>
            <td class="text-right">{{formatRupiah($hutang->jumlah_hutang)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="bg-secondary">
            <th></th>
            <th></th>
            <th></th>

            <th colspan="2">
                <h4 class="text-right">Total Hutang :</h4>
            </th>
            <th colspan="5">
                <h4 class="text-right">{{formatRupiah($totalHutang)}}</h4>
            </th>
            <th></th>
        </tr>
    </tfoot>
</table>

@endsection