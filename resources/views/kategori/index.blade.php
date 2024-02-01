@extends('layouts/dashboard')

@section('title')
Kategori Barang
@endsection

@section('btn')
<div class="card-header">
    <a class="btn btn-primary btn-sm" href="kategoribarang/create">
        Tambah Data
    </a>
</div>
@endsection

@section('content')
<table id="example1" class="table table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Kategori</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @php
        $counter = 1;
        @endphp
        @foreach($kategoribarang as $items)
        <tr>
            <td>{{ $counter }}</td>
            <td>{{ $items->nama }}</td>
            <td class="row">
                <a class="btn btn-info btn-sm" href="/kategoribarang/{{$items->id}}/edit">
                    <i class="fas fa-pencil-alt">
                    </i>

                </a>
                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $items->id }})">
                    <i class="fas fa-trash"></i>
                </a>
                <form id="delete-form-{{ $items->id }}" action="{{ route('kategoribarang.destroy', $items->id) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @php
        $counter++;
        @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>No.</th>
            <th>Nama Kategori</th>
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