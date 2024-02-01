@extends('layouts/dashboard')

@section('title')
Edit Data Barang
@endsection

@section('content')
<form method="POST" action="/barang/{{$barang->id}}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="exampleFormControlSelect2">Kategori</label>
        <select multiple name="kategori_id" class="form-control" id="kategori_id">
            @foreach($kategoris as $kat)<option value="{{$kat->id}}" {{ ($barang->kategori_id == $kat->id) ? 'selected'
                : '' }}>{{$kat->nama}}</option>@endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{ $barang->nama }}">
    </div>
    <div class="form-group">
        <label>Harga Jual</label>
        <input type="text" class="form-control" id="harga" name="harga" value="{{ $barang->harga }}">
    </div>
    {{-- <div class="form-group">
        <label>Jumlah Stok</label>
        <input type="text" class="form-control" id="stok" name="stok" value="{{ $kat->stok }}">
    </div> --}}

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <a class="btn btn-secondary" href="/barang">Cancel</a>
    </div>
</form>
@endsection