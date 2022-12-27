<?php

namespace App\Http\Controllers;
use App\Models\Tpembelian;
use Illuminate\Http\Request;
use App\Models\Tpembelianbarang;
use DB;

class TpembelianController extends Controller
{

    public function index()
    {
        $tpembelian = Tpembelian::all();
        return view('transaksi_pembelian.index', compact('tpembelian'));
    }
    public function show($id)
    {
        $tpembelian = Tpembelian::find($id);

        return view('transaksi_pembelian.show', compact('tpembelian'));
    }
  
  
}