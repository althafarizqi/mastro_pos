@extends('layouts/dashboard')

@section('title')
Data Suplier
@endsection

@section('btn')
<div class="card-header">
    <a class="btn btn-primary btn-sm" href="/suplier/create">
        Tambah Data
    </a>
</div>
@endsection

@section('content')
<table id="example1" class="table table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th style="width: 25%">Nama</th>
            <th style="width: 35%">Alamat</th>
            <th style="width: 15%">Telepon</th>
            <th class="text-center" style="width: 20%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($supliers as $items)

        <tr>
            <td>{{$items -> nama}}</td>
            <td>{{$items -> alamat}}</td>
            <td>{{$items -> telepon}}</td>
            <td class="row">
                <a class="btn btn-info btn-sm" href="/suplier/{{$items->id}}/edit">
                    <i class="fas fa-pencil-alt">
                    </i>

                </a>
                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $items->id }})">
                    <i class="fas fa-trash"></i>
                </a>
                <form id="delete-form-{{ $items->id }}" action="{{ route('suplier.destroy', $items->id) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>

        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Telepon</th>
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