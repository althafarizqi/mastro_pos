@extends('layouts/dashboard')

@section('title')
Home
@endsection


@section('content')
<div class="card card-primary">
    <div class="card-header">
        <div class="user-block">
            <h3 class="card-title">Penjualan</h3>
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="/">
            @csrf
            <div class="row">
                <div class="col form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal">
                </div>
                <div class="col form-group">
                    <label>No. Invoice</label>
                    <input type="text" readonly class="form-control form-control-sm" id="nota_penjualan" name="nota_penjualan"
                        value="{{$nomor}}">
                </div>
                <div class="col form-group">
                    <label for="exampleFormControlSelect2">Nama Pelanggan</label>
                    <select name="pelanggan_id" class="form-control form-control-sm select2" id="pelanggan_id">
                        <option value="">----Pilih Pelanggan----</option>
                        @foreach($pelanggans as $pelanggan)
                        <option value="{{$pelanggan->id}}">{{$pelanggan->nama}}|{{$pelanggan->alamat}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col form-group">
                    <label for="pembayaran">Jenis Pembayaran</label>
                    <select class="form-control form-control-sm" id="pembayaran" name="pembayaran">
                        <option value="Tunai">Tunai</option>
                        <option value="Tempo">Tempo</option>
                    </select>
                </div>
                <div class="col form-group">
                    <label>Tanggal Jatuh tempo</label>
                    <input type="date" class="form-control form-control-sm" id="tanggal_japo" name="tanggal_japo">
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
                                    <th>SubTotal Harga</th>
                                </tr>
                            </thead>
                            <tbody id="data">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="row">
                {{-- <div class="col-4 input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control-sm">PPN. %</span>
                    </div>
                    <input type="number" class="form-control form-control-sm" id="pajak" name="pajak">
                </div>
                <div class="col-4 input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control-sm">Diskon. Rp </span>
                    </div>
                    <input type="number" class="form-control form-control-sm" id="diskon" name="diskon">
                </div> --}}
                <div class="col-4 input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control-sm">Total Harga</span>
                    </div>
                    <input type="text" id="total-harga-input-display" class="form-control form-control-sm">
                </div>
                <div class="col-4 input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control-sm">DPP</span>
                    </div>
                    <input type="text" id="dpp-display" class="form-control form-control-sm">
                    <input type="hidden" id="dpp" name="dpp" class="form-control form-control-sm">
                </div>
                <div class="col-4 input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control-sm">PPN</span>
                    </div>
                    <input type="text" id="ppn-display" class="form-control form-control-sm">
                    <input type="hidden" id="ppn" name="ppn" class="form-control form-control-sm">
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            {{-- <h4 id="total-harga" class="text-bold"></h4> --}}
            <input type="hidden" name="total_harga" id="total-harga-input" value="0">
        </form>
    </div>
</div>


<div class="card card-primary">
    <div class="card-header">
        <div class="user-block">
            <h3 class="card-title">Daftar Penjualan Hari ini</h3>
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Tanggal</th>
                    <th>No. Invoice</th>
                    <th>Pelanggan</th>
                    <th>Pembayaran</th>
                    <th>Total Harga</th>
                    <th style="text-align: center">Tanpa<br />Tanggal</th>
                    <th>Cetak Nota</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualans as $items)

                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$items->tanggal}}</td>
                    <td>{{$items->nota_penjualan}}</td>
                    <td>{{$items->pelanggan->nama}}</td>
                    <td>{{$items->pembayaran}}</td>
                    <td>{{$items->total_harga}}</td>
                    <td style="text-align: center">
                        <form class="form-group" action="cetaknota1/{{$items->id}}" method="get">

                            <input type="hidden" name="cetakTanggal" value="1">
                            <!-- Nilai defaultnya adalah 1 (tercetak) -->
                            <input type="checkbox" name="cetakTanggal" id="cetakTanggal" value="0">
                            <!-- Nilai checkbox 0 (tidak tercetak) -->
                    </td>
                    <td class="row">
                        {{-- <a class="btn btn-info btn-sm mr-1" href="#">
                            PDF
                        </a> --}}

                        <form class="form-group" action="cetaknota1/{{$items->id}}" method="get">

                            {{-- <label for="cetakTanggal">Cetak Tanggal:</label>
                            <input type="hidden" name="cetakTanggal" value="1">
                            <!-- Nilai defaultnya adalah 1 (tercetak) -->
                            <input type="checkbox" name="cetakTanggal" id="cetakTanggal" value="0">
                            <!-- Nilai checkbox 0 (tidak tercetak) -->
                            Tidak
                            <br> --}}
                            <button class="btn btn-danger btn-sm mr-1" type="submit">1</button>
                            <button class="btn btn-danger btn-sm mr-1" type="submit"
                                formaction="cetaknota2/{{$items->id}}">2</button>
                            <button class="btn btn-danger btn-sm" type="submit"
                                formaction="cetaknota3/{{$items->id}}">3</button>

                        </form>
                        {{-- <form action="cetaknota2/{{$items->id}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <a href="{{ route('cetaknota2.nota2', $items->id) }}" class="btn btn-warning btn-sm mr-2">
                                2</a>
                        </form>
                        <form action="cetaknota3/{{$items->id}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <a href="{{ route('cetaknota3.nota3', $items->id) }}" class="btn btn-success btn-sm">
                                3</a>
                        </form> --}}
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="card card-danger">
            <div class="card-header">
                <div class="user-block">
                    <h3 class="card-title">Data Hutang</h3>
                </div>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-hover">
                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Suplier</th>
                            <th>Jumlah</th>
                            <th>Jatuh Tempo</th>
                        </tr>

                    <tbody>
                        @foreach($hutangs as $hutang)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$hutang->pembelian->nota_beli}}</td>
                            <td>{{$hutang->suplier->nama}}</td>
                            <td>{{formatRupiah($hutang->jumlah_hutang)}}</td>
                            <td>{{$hutang->tanggal_japo}}</td>
                            {{-- <td>{{$hutang->status}}</td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col (left) -->
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <div class="user-block">
                    <h3 class="card-title">Data Piutang</h3>
                </div>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Jumlah</th>
                            <th>Jatuh Tempo</th>
                        </tr>
                    <tbody>
                        @foreach($piutangs as $piutang)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$piutang->penjualan->nota_penjualan}}</td>
                            <td>{{$piutang->pelanggan->nama}}</td>
                            <td>{{formatRupiah($piutang->jumlah_piutang)}}</td>
                            <td>{{$piutang->tanggal_japo}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('darmawan')
<script>
    let dataRow = 0;
    $("#add-input").click(() => {
    dataRow++;
    inputRow(dataRow);
    });

    function inputRow(i) {
    let tr = `<tr id="input-tr-${i}">
        <td>
            <select class="form-control select2 form-control-sm" name="barang_id[]">
                <option>Nama Barang | Stok</option>
                @foreach($barangs as $barang)
                <option value="{{$barang->id}}" data-harga="{{ $barang->harga }}">{{ $barang->nama}} | {{ $barang->stok }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="text" class="form-control form-control-sm" name="jumlah[]"></td>
        <td><input type="text" class="form-control form-control-sm" name="harga_satuan[]" value=""></td>
        <td><input type="text" class="form-control form-control-sm" name="subtotal_harga[]"></td>
        <td><button class="btn btn-sm btn-danger delete-record float-right" data-id="${i}">Hapus</button></td>
    </tr>`;
    $("#data").append(tr);

    // Inisialisasi Select2 untuk elemen <select> yang baru ditambahkan
        $(`#input-tr-${i} select`).select2({
            templateResult: function(data) {
                var r = data.text.split('|');
                var $result = $(
                    '<div class="row">' +
                        '<div class="col-md-10">' + r[0] + '</div>' +
                        '<div class="col-md-2">' + r[1] + '</div>' +
                    '</div>'
                );
                return $result;
            }
        });
    }

    $("#data").on("click", ".delete-record", function () {
    let id = $(this).attr("data-id");
    $("#input-tr-" + id).remove();
    updateTotalHarga(); // Update total harga saat menghapus
    });

    // Menangani perubahan dalam dropdown "Pilih Barang"
    $("#data").on("change", 'select[name="barang_id[]"]', function () {
    let selectedOption = $(this).find(":selected");
    let row = $(this).closest("tr");
    let hargaInput = row.find('input[name="harga_satuan[]"]');

    // Mengisi nilai harga satuan dari data-harga yang ada pada option terpilih
    hargaInput.val(selectedOption.data("harga"));


    calculateSubtotal(row); // Hitung subtotal saat mengubah barang terpilih
    });

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

    updateTotalHarga(); // Update total harga setiap kali subtotal berubah
    }

    function updateTotalHarga() {
    let totalHarga = 0;

    $('input[name="subtotal_harga[]"]').each(function () {
    let subtotal = parseFloat($(this).val()) || 0;
    totalHarga += subtotal;
    });

    // Ambil nilai diskon dan pajak
    const diskon = parseFloat($("#diskon").val()) || 0;
    const pajak = parseFloat($("#pajak").val()) || 0;

    // Hitung nilai diskon dan pajak
    // const nilaiDiskon = (totalHarga * diskon / 100); //diskon dengan persen
    const nilaiPajak = (totalHarga * pajak / 100);

    // Hitung total harga setelah diskon dan pajak
    totalHarga = totalHarga - diskon + nilaiPajak;

    Dpp = totalHarga * 100 / 111;
    Ppn = Dpp * 11 / 100;

    Dpp = Math.round(Dpp); // Memutar ke bilangan bulat terdekat
    Ppn = Math.round(Ppn); // Memutar ke bilangan bulat terdekat

    $('#dpp').val(Dpp);
    $('#ppn').val(Ppn);

    $('#dpp-display').val(formatRupiah(Dpp));
    $('#ppn-display').val(formatRupiah(Ppn));

    $("#total-harga").text(formatRupiah(totalHarga));
    $('#total-harga-input').val(totalHarga);
    $('#total-harga-input-display').val(formatRupiah(totalHarga));
    }

    function formatRupiah(value) {
    return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    }).format(value);
    }

    $(document).ready(function () {
        $("#diskon").val(0);
        $("#pajak").val(0);
    updateTotalHarga();

    $("#diskon").on("change", function() {
    updateTotalHarga();
    });

    $("#pajak").on("change", function() {
    updateTotalHarga();
    });


    });


</script>
@endsection
