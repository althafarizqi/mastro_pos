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
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                    <tfoot>
                        <th scope="row"></th>
                        <td colspan="2">
                            <h4 class="text-bold float-right">Total Pembelian :</h4>
                        </td>
                        <td>
                            <input type="text" id="total-harga-input-display"
                                class="text-bold form-control form-control">
                            <input type="hidden" id="total-harga-input" class="form-control text-left"
                                name="total_harga" value="0">
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
            <select class="form-control form-control-sm select2" name="barang_id[]">
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                <option value="{{$barang->id}}">{{$barang->nama}}</option>
                @endforeach
            </select>
        </td>
        <td><input type="text" class="form-control form-control-sm" name="jumlah[]"></td>
        <td><input type="text" class="form-control form-control-sm" name="harga_satuan[]"></td>
        <td><input type="text" class="form-control form-control-sm" name="subtotal_harga[]"></td>
        <td><button class="btn btn-sm btn-danger delete-record float-right" data-id="${i}">Hapus</button></td>
    </tr>`
    $('#data').append(tr);

    // Inisialisasi Select2 untuk elemen <select> yang baru ditambahkan
        $(`#input-tr-${i} select`).select2();
    }


    $('#data').on('click', '.delete-record', function() {
    let id = $(this).attr('data-id')
    $('#input-tr-'+id).remove()
    })

    // Menangani perubahan dalam input jumlah dan harga satuan
    $("#data").on("input", 'input[name="jumlah[]"], input[name="harga_satuan[]"]', function () {
    let row = $(this).closest("tr");
    calculateSubtotal(row); // Hitung subtotal saat mengubah jumlah atau harga satuan
    });

    function calculateSubtotal(row) {
    let jumlahInput = row.find('input[name="jumlah[]"]');
    let hargaInput = row.find('input[name="harga_satuan[]"]');
    let subtotalInput = row.find('input[name="subtotal_harga[]"]');

    let jumlah = parseInt(jumlahInput.val());
    let hargaSatuan = parseFloat(hargaInput.val());

    // Periksa apakah jumlah dan hargaSatuan adalah angka yang valid
    if (!isNaN(jumlah) && !isNaN(hargaSatuan)) {
    let subtotal = jumlah * hargaSatuan;
    subtotalInput.val(subtotal); //(subtotal.toFixed()); // Mengatur 2 angka desimal
    } else {
    subtotalInput.val(""); // Atur ke kosong jika salah satu input tidak valid
    }
    updateTotalHarga()
    }

    function updateTotalHarga() {
    let totalHarga = 0;

    $('input[name="subtotal_harga[]"]').each(function () {
    let subtotal = parseFloat($(this).val()) || 0;
    totalHarga += subtotal;
    });

    $('#total-harga-input').val(totalHarga);
    $('#total-harga-input-display').val(formatRupiah(totalHarga));
    }

    function formatRupiah(value) {
    return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    }).format(value);
    }
</script>
@endsection
