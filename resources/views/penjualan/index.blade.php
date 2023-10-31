@extends('layouts/dashboard')

@section('title')
Data Penjualan
@endsection

@section('btn')
<div class="card-header">
    <a class="btn btn-primary btn-sm" href="/penjualan/create">
        Tambah Data
    </a>
</div>
@endsection

@section('content')
<table id="example1" class="table table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th></th>
            <th>Tanggal</th>
            <th>No. Invoice</th>
            <th>Pelanggan</th>
            <th>Pembayaran</th>
            <th>Status</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $items)

        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$items->tanggal}}</td>
            <td>{{$items->nota_penjualan}}</td>
            <td>{{$items->nama_pelanggan}}</td>
            <td>{{$items->pembayaran}}</td>
            <td>{{$items->status}}</td>
            <td>{{$items->total_harga}}</td>
            {{-- <td class="row">
                <a class="btn btn-info btn-sm" href="/penjualan/{{$items->id}}/edit">
                    <i class="fas fa-pencil-alt">
                    </i>

                </a>
                <form action="penjualan/{{$items->id}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <a href="{{ route('penjualan.destroy', $items->id) }}" class="btn btn-danger btn-sm"
                        data-confirm-delete="true">
                        <i class="fas fa-trash">
                        </i>

                    </a>
                </form>
            </td> --}}
        </tr>

        @endforeach
    </tbody>
</table>
@endsection