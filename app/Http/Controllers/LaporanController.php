<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['customer', 'service'])->get();

        return view('laporan.index', compact('transaksis'));
    }
}