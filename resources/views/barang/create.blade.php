@extends('layouts/dashboard')

@section('title')
Tambah Data Barang
@endsection

@section('content')
<form method="POST" action="/barang">
    @csrf
    <div class="form-group">
        <label for="exampleFormControlSelect2">Kategori</label>
        <select multiple name="kategori_id" class="form-control" id="kategori_id">
            @foreach($kategoris as $kat)<option value="{{$kat->id}}">{{$kat->nama}}</option>@endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" class="form-control" id="nama" name="nama">
    </div>
    <div class="form-group">
        <label>Harga Jual</label>
        <input type="text" class="form-control" id="harga" name="harga">
    </div>
    <input type="hidden" class="form-control" id="stok" name="stok" value="0">
    {{-- <div class="form-group">
        <label>Jumlah Stok</label>
        <label style="font-size: smaller" for="">*jika tidak ada isi dengan 0 Nol</label>
    </div> --}}
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <a class="btn btn-secondary" href="/barang">Cancel</a>
    </div>
</form>
@endsection