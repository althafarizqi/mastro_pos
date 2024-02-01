@extends('layouts/dashboard')

@section('title')
Pembayaran Hutang
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
            <th>Suplier</th>
            <th>Jumlah</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
            <th></th>
        </tr>

    <tbody>
        @foreach($hutangs as $hutang)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$hutang->pembelian->nota_beli}}</td>
            <td>{{$hutang->suplier->nama}}</td>
            <td>{{formatRupiah($hutang->jumlah_hutang)}}</td>
            <td>{{$hutang->tanggal_japo}}</td>
            <td>{{$hutang->status}}</td>
            <td>
                <form action="{{ route('hutang.update', $hutang->id) }}" method="POST">
                    @csrf
                    @method("put")
                    @if($hutang->status === 'Lunas')
                    <button class="btn btn-secondary btn-sm" disabled>Bayar</button>
                    @else
                    <a href="{{ route('hutang.update', $hutang->id) }}" class="btn btn-primary btn-sm"
                        onclick="event.preventDefault(); confirmUpdate(event);">
                        Bayar
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
        text: 'Apakah Anda yakin sudah dibayar?',
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
