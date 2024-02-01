<table id="example2" class="table dataTable">
    <thead>
        {{-- <tr>
            <th colspan="8" style="text-align: center; font-weight: 700">Laporan Laba Rugi Periode
                {{\Carbon\Carbon::parse($tanggal_awal)->format('d M Y')}} s/d
                {{\Carbon\Carbon::parse($tanggal_akhir)->format('d M Y')}}</th>
            <th style="display: none"></th>
            <th style="display: none"></th>
            <th style="display: none"></th>
            <th style="display: none"></th>
            <th style="display: none"></th>
            <th style="display: none"></th>
            <th style="display: none"></th>
        </tr> --}}
        <tr class="text-center">
            <th style="font-weight: 700">Invoice</th>
            <th style="font-weight: 700">Tanggal</th>
            <th style="font-weight: 700">Customer</th>
            <th style="font-weight: 700">Barang</th>
            <th style="font-weight: 700">QTY</th>
            <th style="font-weight: 700">Harga Jual</th>
            <th style="font-weight: 700">Harga Beli</th>
            <th style="font-weight: 700">Laba/Rugi</th>
        </tr>
    </thead>
    <tbody>
        @php
        $currentNotaPenjualan = null;
        $totalKelompok = 0;
        $totalKelompok1 = 0;
        $totalKelompok2 = 0;
        $grandTotalPenjualan = 0;
        $grandTotalPembelian = 0;
        $grandTotalLaba = 0;
        @endphp

        @foreach ($results as $result)
        @if ($result->nota_penjualan !== $currentNotaPenjualan)
        @if ($currentNotaPenjualan !== null)
        <tr style="background-color: #7c7d7c; color: white">
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right"></td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right"></td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right"></td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right"></td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right">Total</td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right">
                {{formatRupiah($totalKelompok)}}</td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right">
                {{formatRupiah($totalKelompok1)}}</td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right">
                {{formatRupiah($totalKelompok2)}}</td>
        </tr>
        @php $grandTotalPenjualan += $totalKelompok; $totalKelompok = 0; @endphp
        @php $grandTotalPembelian += $totalKelompok1; $totalKelompok1 = 0; @endphp
        @php $grandTotalLaba += $totalKelompok2; $totalKelompok2 = 0; @endphp
        @endif
        <tr>
            <td>{{$result->nota_penjualan}}</td>
            <td>{{ \Carbon\Carbon::parse($result->tanggal)->format('d M Y') }}</td>
            <td>{{$result->nama_pelanggan}}</td>
            <td>{{$result->nama_barang_penjualan}}</td>
            <td style="text-align: center">{{$result->jumlah}}</td>
            <td style="text-align: right">{{formatRupiah($result->harga_satuan_penjualan)}}</td>
            <td style="text-align: right">{{formatRupiah($result->jumlah*$result->rasio_harga_pembelian)}}</td>
            <td style="text-align: right">
                {{formatRupiah($result->harga_satuan_penjualan-$result->jumlah*$result->rasio_harga_pembelian)}}
            </td>
        </tr>

        @php $currentNotaPenjualan = $result->nota_penjualan; @endphp
        @else
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$result->nama_barang_penjualan}}</td>
            <td style="text-align: center">{{$result->jumlah}}</td>
            <td style="text-align: right">{{formatRupiah($result->harga_satuan_penjualan)}}</td>
            <td style="text-align: right">{{formatRupiah($result->jumlah*$result->rasio_harga_pembelian)}}</td>
            <td style="text-align: right">
                {{formatRupiah($result->harga_satuan_penjualan-$result->jumlah*$result->rasio_harga_pembelian)}}
            </td>
        </tr>
        @endif

        @php
        $totalKelompok += $result->harga_satuan_penjualan;
        $totalKelompok1 += $result->rasio_harga_pembelian*$result->jumlah;
        $totalKelompok2 += $result->harga_satuan_penjualan-$result->rasio_harga_pembelian*$result->jumlah;
        @endphp
        @endforeach

        @if ($currentNotaPenjualan !== null)
        <tr style="background-color: #7c7d7c; color: white">
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right"></td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right"></td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right"></td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right"></td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right">Total</td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right">
                {{formatRupiah($totalKelompok)}}</td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right">
                {{formatRupiah($totalKelompok1)}}</td>
            <td style="background-color: #7c7d7c; color: white; font-weight: 700; text-align: right">
                {{formatRupiah($totalKelompok2)}}</td>
        </tr>
        @php $grandTotalPenjualan += $totalKelompok; @endphp
        @php $grandTotalPembelian += $totalKelompok1; @endphp
        @php $grandTotalLaba += $totalKelompok2; @endphp
        @endif

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right; font-weight: 700;">Grand Total Penjualan</td>
            <td style="text-align: right; font-weight: 700">{{formatRupiah($grandTotalPenjualan)}}</td>
            <td style="display: none"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right; font-weight: 700;">Grand Total Pembelian / HPP</td>
            <td style="text-align: right; font-weight: 700">{{formatRupiah($grandTotalPembelian)}}</td>
            <td style="display: none"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right; font-weight: 700;">Grand Total Laba</td>
            <td style="text-align: right; font-weight: 700">{{formatRupiah($grandTotalLaba)}}</td>
            <td style="display: none"></td>
        </tr>
    </tbody>
    {{-- <tfoot>
        <tr class="text-center">
            <th>Invoice</th>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>Barang</th>
            <th>QTY</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Laba/Rugi</th>
        </tr>
    </tfoot> --}}
</table>
