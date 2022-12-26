<?php

namespace App\Http\Controllers;
use App\Models\Tpembelian;
use Illuminate\Http\Request;

class TpembelianController extends Controller
{

    public function index()
    {
        $tpembelian = Tpembelian::all();
        return view('transaksi_pembelian.index', compact('tpembelian'));
    }
  
  
}