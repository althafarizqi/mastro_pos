@extends('layouts/dashboard')

@section('title')
Data Barang
@endsection

@section('btn')
<div class="card-header">
    <a class="btn btn-primary btn-sm" href="barang/create">
        Tambah Data
    </a>
</div>
@endsection

@section('content')
<table id="example1" class="table table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>Kategori Barang</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Jumlah Stok</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangs as $items)

        <tr>
            <td>{{$items->kategoribarang->nama}}</td>
            <td>{{$items->nama}}</td>
            <td>{{formatRupiah($items->harga)}}</td>
            <td>{{$items->stok}}</td>
            <td class="row">
                <a class="btn btn-info btn-sm" href="/barang/{{$items->id}}/edit">
                    <i class="fas fa-pencil-alt">
                    </i>

                </a>
                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $items->id }})">
                    <i class="fas fa-trash"></i>
                </a>
                <form id="delete-form-{{ $items->id }}" action="{{ route('barang.destroy', $items->id) }}" method="POST"
                    style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>

        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Kategori Barang</th>
            <th>Nama Barang</th>
            <th>Harga Barang</th>
            <th>Jumlah Stok</th>
            <th></th>
        </tr>
    </tfoot>
</table>
@endsection

@section('darmawan')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If user confirms, submit the delete form
                document.querySelector(`form#delete-form-${id}`).submit();
            }
        });
    }
</script>
@endsection