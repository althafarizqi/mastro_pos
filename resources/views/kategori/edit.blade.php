@extends('layouts/dashboard')

@section('title')
Kategori Barang
@endsection

@section('content')

<form method="POST" action="/kategoribarang/{{$kategoribarang->id}}">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{$kategoribarang->nama}}">
    </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <a class="btn btn-secondary" href="/kategoribarang">Cancel</a>
    </div>
</form>

@endsection