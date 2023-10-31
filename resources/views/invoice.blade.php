<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title></title>

    <!-- Favicon -->

    <link rel="icon" href="{{asset('img/logo.png')}}" type="image/x-icon" />

    <!-- Invoice styling -->
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 2px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            /* border-collapse: collapse; */
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 5px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td>
                    <table style="border: 2px solid black">
                        <tr>
                            <td class="title">
                                <img src="img/logo.png" alt="Mastro Logo" style="width: 700%; max-width: 100px" />
                            </td>
                            <td style="text-align: left; width: 80%">
                                <h1>MASTRO COMPUTER</h1><br />
                                Branggah RT 02/ RW 08 Nyatnyono-Ungaran<br />
                                Telp: 085 640 501 393 / 0899 590 9910
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                Mastro Comp, Inc.<br />
                                Jl. Nyatnyono 1234<br />
                                Ungaran, Jawa Tengah
                            </td>

                            <td>
                                {{$penjualanData->pelanggan->nama}}<br />
                                {{$penjualanData->pelanggan->alamat}}<br />
                                {{$penjualanData->pelanggan->telepon}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- <tr class="heading">
					<td>Payment Method</td>

					<td>Check #</td>
				</tr> -->

            <!-- <tr class="details">
					<td>Check</td>

					<td>1000</td>
				</tr> -->

            <tr class="heading">
                <td>Nama Barang</td>

                <td style="text-align: center; width: 20px;">Jumlah</td>

                <td style="width: 150px;">Harga Satuan</td>

                <td style="width: 200px">Sub Total</td>
            </tr>
            @foreach($detailPenjualanData as $items)
            <tr class="item">
                <td>{{$items->barang->nama}}</td>

                <td style="text-align: center;">{{$items->jumlah}}</td>

                <td>{{formatRupiah($items->harga_satuan)}}</td>

                <td>{{formatRupiah($items->subtotal_harga)}}</td>
            </tr>
            @endforeach

            <!-- <tr class="item last">
					<td>Domain name (1 year)</td>

					<td></td>
					
					<td></td>

					<td>$10.00</td>
				</tr> -->
            <tr class="total">
                <td></td>

                <td></td>

                <td style="text-align: right; font-weight: bold">PPN % :</td>

                <td> {{$penjualanData->pajak}}</td>
            </tr>
            <tr class="total">
                <td></td>

                <td></td>

                <td style="text-align: right; font-weight: bold">Diskon :</td>

                <td> {{formatRupiah($penjualanData->diskon, true)}}</td>
            </tr>
            <tr class="total">
                <td></td>

                <td></td>

                <td style="text-align: right; font-weight: bold">Total :</td>

                <td> {{formatRupiah($penjualanData->total_harga, true)}}</td>
            </tr>
        </table>
    </div>


    <script>
        var blob = new Blob([output], { type: 'application/pdf' });
        var url = window.URL.createObjectURL(blob);
        
        var printWindow = window.open(url);
        printWindow.print();
    </script>
</body>

</html>