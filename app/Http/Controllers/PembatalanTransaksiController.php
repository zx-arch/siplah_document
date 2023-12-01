<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PembatalanTransaksiController extends Controller
{
    public function index()
    {
        return view('documents.pembatalan_transaksi');
    }

    public function download()
    {
        $pdf = Pdf::loadView('documents.template-pembatalan_transaksi');
        return view('documents/template-pembatalan_transaksi');
    }
}