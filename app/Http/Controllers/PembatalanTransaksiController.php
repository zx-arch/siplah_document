<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembatalanTransaksiController extends Controller
{
    public function index()
    {
        return view('documents.pembatalan_transaksi');
    }
}