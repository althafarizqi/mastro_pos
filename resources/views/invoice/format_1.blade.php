<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 8px;
            border: 1px solid #eee;
            box-shadow: 0 0 0.5px rgba(0, 0, 0, 0.15);
            font-size: 12px;
            line-height: 20px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr>
                <td>
                    <table style="border: 0px solid black; width: 800px;">
                        <tr style="border: 0px solid black;">
                            <td style="border: 0px solid black; width: 100px;">
                                <img src="{{asset('img/mc.png')}}" alt="Mastro Logo" style="max-width: 120px " />
                            </td>
                            <td style="border: 0px solid black; ">
                                <p style="margin-left: 5px; margin-top: 5px; font-size: 28px; font-weight: 700;">MASTRO
                                    COMPUTER</p>
                                <p style="margin-left: 5px; margin-top: -30px; font-size: small;">Branggah RT 02/ RW 08
                                    Nyatnyono-Ungaran
                                </p>
                                <p style="margin-left: 5px; margin-top: -15px; font-size: small;">Telp: 085 640 501 393
                                    / 0899 590 9910
                                </p>
                            </td>
                            <td style="border: 0px solid black; width: 230px;">
                                <p style="font-size: x-large; font-weight: 700; text-align: center;">INVOICE</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table style="border: 0px solid black; width: 800px; margin-top: -15px">
                        <tr style="border: 0px solid black;">
                            <td colspan="2" style="border: 0px solid black; width: 150px;">
                                <table style="margin-top: -10;">
                                    <tr>
                                        <td>No</td>
                                        <td>: {{$penjualanData->nota_penjualan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>: @if ($cetakTanggal) {{ formatDate($penjualanData->tanggal) }} @endif</td>
                                    </tr>
                                </table>
                            </td>
                            <!-- <td style="border: 0px solid black; "></td> -->
                            <td style="border: 0px solid black; width: 230px;">
                                <table style="margin-top: -10;">
                                    <tr>
                                        <td>

                                            Yth. {{$penjualanData->pelanggan->nama}} <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$penjualanData->pelanggan->alamat}}
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$penjualanData->pelanggan->telepon}}

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table style="border: 1px solid black; width: 800px;">
                        <thead>
                            <th
                                style="border-right: 1px solid black; border-bottom: 1px solid black;  max-width: 10px;">
                                No</th>
                            <th style="border-right: 1px solid black; border-bottom: 1px solid black; max-width: 100%">
                                Nama Barang</th>
                            <th style="border-right: 1px solid black; border-bottom: 1px solid black; max-width: 10px;">
                                Qty</th>
                            <th style="border-right: 1px solid black; border-bottom: 1px solid black; max-width: 35px;">
                                Harga</th>
                            <th style="border-bottom: 1px solid black; max-width: 35px">Total</th>
                        </thead>
                        @foreach($detailPenjualanData as $items)
                        <tr style="border: 0px solid black;">
                            <td style="border-right: 1px solid black; text-align: center;">{{$loop->iteration}}</td>
                            <td style="border-right: 1px solid black; padding-left: 5px">{{$items->barang->nama}}</td>
                            <td style="border-right: 1px solid black; text-align: center;">{{$items->jumlah}}</td>
                            <td style="border-right: 1px solid black; text-align: right; padding-right: 5px">
                                {{formatRupiah($items->harga_satuan)}}</td>
                            <td style="border: 0px solid black; text-align: right; padding-right: 5px">
                                {{formatRupiah($items->subtotal_harga)}}</td>
                        </tr>
                        @endforeach
                        @php
                        $rowCount = count($detailPenjualanData);
                        $emptyRowCount = max(7 - $rowCount, 0);
                        @endphp

                        @for ($i = 0; $i < $emptyRowCount; $i++) <tr style="border: 0px solid black;">
                            <td style="border-right: 1px solid black; text-align: center; height: 20px;"></td>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="border-right: 1px solid black; text-align: center;"></td>
                            <td style="border-right: 1px solid black; text-align: right;"></td>
                            <td style="border: 0px solid black; text-align: right;"></td>
            </tr>
            @endfor
            <tfoot style="border: 1px solid black;">
                <th colspan="3"
                    style="border-top: 1px solid black; max-width: 6px; text-align: left; padding-left: 5px">
                    Terbilang : {{terbilang($penjualanData->total_harga).'Rupiah'}}</th>
                <!-- <th style="border: 2px solid black; max-width: 100%">Nama Barang</th> -->
                <!-- <th style="border: 2px solid black; max-width: 6px;">Qty</th> -->
                <th
                    style="border-top: 1px solid black; border-left: 1px solid black; max-width: 35px; text-align: right; padding-right: 5px">
                    Jumlah</th>
                <th
                    style="border-top: 1px solid black; border-left: 1px solid black; max-width: 35px; text-align: right; padding-right: 5px">
                    {{formatRupiah($penjualanData->total_harga)}}</th>
            </tfoot>
        </table>
        </td>
        </tr>

        <tr>
            <td>
                <table style="border: 0px solid black; width: 800px;">
                    <tr style="border: 0px solid black;">
                        <td colspan="3" style="border: 0px solid black; max-width: 50%; text-align: center; ">
                            Penerima<br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                        </td>
                        <td colspan="3" style="border: 0px solid black; max-width: 50%; text-align: center; ">Hormat
                            Kami,<br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lutfi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>
    </div>
</body>

</html>