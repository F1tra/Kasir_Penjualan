<?php

namespace App\Http\Controllers;
use App\Models\Tpembelianbarang;
use Illuminate\Http\Request;

class TpembelianbarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tpembelianb = TpembelianBarang::all();
        return view('transaksi_pembelian_barang.index', compact('tpembelianb'));
    }

   
}