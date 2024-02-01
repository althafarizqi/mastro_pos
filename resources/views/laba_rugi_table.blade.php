@extends('layouts/dashboard')

@section('title')
Laba Rugi /Barang
@endsection

@section('content')

<div class="card-header">
    <form action="{{ route('labarugitable.hasil') }}" method="get">
        <div class="input-group">
            <select style="width: 450px" class="form-control select2" name="barangId">
                <option value="">----Pilih Barang----</option>
                @foreach($barangs as $barang)
                <option value="{{$barang->id}}">{{ $barang-> nama}}</option>
                @endforeach
            </select>
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-primary" name="showData">Tampilkan</button>
            </div>
        </div>
    </form>
</div>
<div class="card-body">
    <table id="example2" class="table dataTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Jumlah Penjualan</th>
                <th>Total Pendapatan</th>
                <th>Total Hpp</th>
                <th>Laba/Rugi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $result)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$result->nama_barang}}</td>
                <td>{{$result->total_penjualan}}</td>
                <td>{{formatRupiah($result->total_pendapatan_penjualan)}}</td>
                <td>{{formatRupiah($result->harga_pokok)}}</td>
                <td>{{formatRupiah($result->laba_rugi)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection