@extends('layouts/dashboard')

@section('title')
History Penjualan /Barang
@endsection

@section('content')

<div class="card-header">
    <form action="{{ route('historybarang.index') }}" method="get">
        <div class="input-group">
            <select style="width: 450px" class="ustom-select select2" name="barangId">
                <option value="">----Pilih Barang----</option>
                @foreach($barangs as $barang)
                <option value="{{$barang->id}}" data-harga="{{ $barang->harga }}">{{ $barang-> nama}}</option>
                @endforeach
            </select>
            <select name="pelangganId" class="custom-select select2" id="inputGroupSelect04"
                aria-label="Example select with button addon">
                <option value="">----Pilih Customer----</option>
                @foreach($pelanggans as $pelanggan)
                {{-- <option value="{{ $pelanggan->id }}" @if($pelanggan->id == $pelanggan_id) selected @endif>{{ --}}
                <option value="{{ $pelanggan->id }}">{{$pelanggan->nama }}</option>
                @endforeach
            </select>
            {{-- <input type="date" name="tanggal_awal" class="form-control">
            <input type="date" name="tanggal_akhir" class="form-control"> --}}
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
                <th>Tanggal</th>
                <th>Nama Customer</th>
                <th>Nama Barang</th>
                <th>Harga Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($history as $result)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$result->tanggal}}</td>
                <td>{{$result->nama_pelanggan}}</td>
                <td>{{$result->nama_barang}}</td>
                <td>{{formatRupiah($result->harga_satuan)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection