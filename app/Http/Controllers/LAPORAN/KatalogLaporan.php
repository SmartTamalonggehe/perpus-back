<?php

namespace App\Http\Controllers\LAPORAN;

use App\Models\Katalog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class KatalogLaporan extends Controller
{
    function index(Request $request)
    {
        $jenis = $request->jenis;
        $tahun = $request->tahun;
        $data = Katalog::with('class_sub.class_umum')
            ->when($jenis, function ($query) use ($jenis) {
                $query->where('jenis', $jenis);
            })
            ->when($tahun, function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            })
            ->get();
        // return $data;
        // cetak pdf
        $pdf = Pdf::loadView('laporan.katalog', [
            'data' => $data,
            'jenis' => $jenis,
            'tahun' => $tahun
        ]);
        return $pdf->stream("Laporan Katalog $jenis $tahun.pdf");
        return view('laporan.katalog', [
            'data' => $data,
            'jenis' => $jenis,
            'tahun' => $tahun
        ]);
    }
}
