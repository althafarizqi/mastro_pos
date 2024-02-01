<?php

function formatRupiah($nominal, $prefix=false)
{
    if ($prefix) {
        return "Rp. " . number_format($nominal, 0, '.', ',');
    }
    return number_format($nominal, 0, '.', ',');
}


function terbilang($x) 
{
  $angka = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];

  if ($x < 12)
    return " " . $angka[$x];
  elseif ($x < 20)
    return terbilang($x - 10) . " Belas";
  elseif ($x < 100)
    return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
  elseif ($x < 200)
    return "Seratus" . terbilang($x - 100);
  elseif ($x < 1000)
    return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
  elseif ($x < 2000)
    return "Seribu" . terbilang($x - 1000);
  elseif ($x < 1000000)
    return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
  elseif ($x < 1000000000)
    return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
}

function daftar_bulan()
{
    return [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
}

function daftar_tahun($awal, $akhir)
{
    $tahun = range($awal, $akhir);
    return array_combine($tahun, $tahun);
}


function formatDate($date, $format = 'd-m-Y')
{
    return \Carbon\Carbon::parse($date)->format($format);
}