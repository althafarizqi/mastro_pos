@extends('layouts/dashboard')

@section('title')
Laporan Laba Rugi
@endsection

@section('content')

<div class="card-header">
    <form action="{{ route('labarugi.index') }}" method="get">
        <div class="input-group">
            <input type="date" name="tanggal_awal" class="form-control">
            <input type="date" name="tanggal_akhir" class="form-control">
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </form>
</div>
<div class="card-body">
    <div>
        <form action="{{ route('labarugi.exportexcell') }}" method="get">
            <div>
                <input type="hidden" name="tanggalAwal" value="{{$tanggal_awal}}" class="form-control">
                <input type="hidden" name="tanggalAkhir" value="{{$tanggal_akhir}}" class="form-control">
                <div>
                    <button type="submit" class="btn btn-sm btn-secondary mb-2">Export Excell</button>
                </div>
            </div>
        </form>
    </div>
    @include('table_laba_rugi',$results)
</div>
@endsection