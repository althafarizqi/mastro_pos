@extends('layouts/dashboard')

@section('title')
Penerimaan Piutang
@endsection

@section('btn')
{{-- <div class="card-header">
    <a class="btn btn-primary btn-sm" href="barang/create">
        Tambah Data
    </a>
</div> --}}
@endsection

@section('content')
<table id="example1" class="table table-responsive-sm table-hover dataTable dtr-inline">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice</th>
            <th>Pelanggan</th>
            <th>Jumlah</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
            <th></th>
        </tr>
    <tbody>
        @foreach($piutangs as $piutang)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$piutang->penjualan->nota_penjualan}}</td>
            <td>{{$piutang->pelanggan->nama}}</td>
            <td>{{formatRupiah($piutang->jumlah_piutang)}}</td>
            <td>{{$piutang->tanggal_japo}}</td>
            <td>{{$piutang->status}}</td>
            <td>
                <form action="piutang/update{{$piutang->id}}" method="POST">
                    @csrf
                    @method("put")
                    @if($piutang->status === 'Lunas')
                    <button class="btn btn-secondary btn-sm" disabled>Terima</button>
                    @else
                    <a href="{{ route('piutang.update', $piutang->id) }}" class="btn btn-primary btn-sm"
                        onclick="event.preventDefault(); confirmUpdate(event);">
                        Terima
                    </a>
                    @endif
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
    </thead>
</table>

@endsection

@section('darmawan')
<script>
    function confirmUpdate(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin uang sudah diterima?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Sudah!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to the edit route when confirmed
            window.location = event.target.href;
        }
    });
}
</script>
@endsection