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

    public function edit($id)
    {
        $barang = Mbarang::find($id);
        return view('master_barang.edit', compact('barang'));
    }
    public function update(request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga_satuan' => 'required',
        ]);

        $barang = Mbarang::find($id);

        $data_barang = [
            'nama_barang' => $request->nama_barang,
            'harga_satuan' => $request->harga_satuan,
        ];

        $barang->update($data_barang);
        Alert::success('Berhasil', 'Mengubah Data Barang');
        return redirect('/master-barang');
    }


}