@extends('layouts/dashboard')

@section('title')
Edit Suplier
@endsection

@section('content')
<form method="POST" action="/suplier/{{$supliers->id}}">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{$supliers->nama}}">
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <input type="text" class="form-control" id="alamat" name="alamat" value="{{$supliers->alamat}}">
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input type="text" class="form-control" id="telepon" name="telepon" value="{{$supliers->telepon}}">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <a class="btn btn-secondary" href="/suplier">Cancel</a>
    </div>
</form>
@endsection