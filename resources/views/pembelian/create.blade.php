@extends('layouts/dashboard')

@section('title')
Transaksi Pembelian
@endsection

@section('content')

<form method="POST" action="/pembelian">
    @csrf
    <div class="row">
        <div class="col form-group">
            <label>Tanggal</label>
            <input type="date" class="form-control form-control" id="tanggal" name="tanggal">
        </div>
        <div class="col form-group">
            <label>No. Invoice</label>
            <input type="text" class="form-control form-control" id="nota_beli" name="nota_beli">
        </div>
        <div class="col form-group">
            <label for="exampleFormControlSelect2">Nama Suplier</label>
            <select name="suplier_id" class="form-control" id="suplier_id">
                <option value="">----Pilih Suplier----</option>
                @foreach($supliers as $suplier)
                <option value="{{$suplier->id}}">{{$suplier->nama}}</option>
                @endforeach
            </select>
        </div>
        <div class="col form-group">
            <label for="pembayaran">Jenis Pembayaran</label>
            <select class="form-control" id="pembayaran" name="pembayaran">
                <option value="Tunai">Tunai</option>
                <option value="Tempo">Tempo</option>
            </select>
        </div>
        <div class="col form-group">
            <label>Tanggal Jatuh tempo</label>
            <input type="date" class="form-control" id="tanggal_japo" name="tanggal_japo">
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="table-responsive-sm">
                <a class="btn btn-sm btn-primary float-right" id="add-input">Tambah Barang</a>
                <table class="table table-sm table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 35%">Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                    <tfoot>
                        <th scope="row"></th>
                        <td>
                            <h4 class="text-bold float-right">Total Pembelian :</h4>
                        </td>
                        <td colspan="3">
                            <input type="text" class="form-control text-left" name="total_harga">
                        </td>
                    </tfoot>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <a class="btn btn-secondary" href="/pembelian">Cancel</a>
    </div>
</form>


@endsection

@section('darmawan')
<script>
    let dataRow = 0
    $('#add-input').click( () => {
    dataRow++
    inputRow(dataRow)
    })
    
    function inputRow(i) {
    let tr = `<tr id="input-tr-${i}">
        <td>
            <select class="form-control form-control-sm" name="barang_id[]">
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                <option value="{{$barang->id}}">{{$barang->nama}}</option>
                @endforeach
            </select>
        </td>
        <td><input type="text" class="form-control form-control-sm" name="jumlah[]"></td>
        <td><input type="text" class="form-control form-control-sm" name="harga[]"></td>
        <td><button class="btn btn-sm btn-danger delete-record float-right" data-id="${i}">Hapus</button></td>
    </tr>`
    $('#data').append(tr);
    }
    
    $('#data').on('click', '.delete-record', function() {
    let id = $(this).attr('data-id')
    $('#input-tr-'+id).remove()
    })

    // Menangani perubahan dalam dropdown "Pilih Barang"
    $('#data').on('change', 'select[name="barang_id[]"]', function() {
    let selectedOption = $(this).find(":selected");
    let row = $(this).closest('tr');
    let jumlahInput = row.find('input[name="jumlah[]"]');
    let hargaInput = row.find('input[name="harga[]"]');
    
    // Mengisi nilai jumlah dan harga berdasarkan data yang dipilih dari dropdown
    jumlahInput.val(selectedOption.data('jumlah'));
    hargaInput.val(selectedOption.data('harga'));
    });
</script>
@endsection