<?php

namespace App\Http\Controllers;
use App\Models\Tpembelian;
use Illuminate\Http\Request;
use App\Models\Tpembelianbarang;
use DB;
use PDF;

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
    public function pdf()
    {
        $tpembelian = Tpembelian::all();
        $pdf = PDF::loadview('transaksi_pembelian.pdf', compact('tpembelian'));
        return $pdf->stream('transaksi_pembelian.pdf');
    }
    public function pdf_detail($id)
    {
        $tpembelian = Tpembelian::find($id);
        $pdf = PDF::loadview('transaksi_pembelian.pdf_detail', compact('tpembelian'));
        return $pdf->stream('transaksi_pembelian_detail.pdf');
    }
   
  
  
}