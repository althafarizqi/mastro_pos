@extends('layouts/dashboard')

@section('title')
Edit Pelanggan
@endsection

@section('content')
<form method="POST" action="/pelanggan/{{$pelanggans->id}}">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{$pelanggans->nama}}">
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <input type="text" class="form-control" id="alamat" name="alamat" value="{{$pelanggans->alamat}}">
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input type="text" class="form-control" id="telepon" name="telepon" value="{{$pelanggans->telepon}}">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <a class="btn btn-secondary" href="/pelanggan">Cancel</a>
    </div>
</form>
@endsection