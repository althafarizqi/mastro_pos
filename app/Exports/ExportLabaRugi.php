<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class ExportLabaRugi implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $results;
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($results, $tanggal_awal, $tanggal_akhir)
    {
        $this->results = $results;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function view(): View
    {
        return view('table_laba_rugi', [
            'results' => $this->results,
            'tanggal_awal' => $this->tanggal_awal,
            'tanggal_akhir' => $this->tanggal_akhir,
        ]);
    }
}