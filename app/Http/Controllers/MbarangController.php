<?php

namespace App\Http\Controllers;

use App\Models\Mbarang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MbarangController extends Controller
{
   
    public function index()
    {
        $barang = Mbarang::all();
        return view('master_barang.index', compact('barang'));
    }
    public function create()
    {
        return view('master_barang.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga_satuan' => 'required'
        ]);

        Mbarang::create([
            "nama_barang" => $request["nama_barang"],
            "harga_satuan" => $request["harga_satuan"]
        ]);

        Alert::success('Berhasil', 'Menambahkan Data Barang');
        return redirect('/master-barang');
    }


}