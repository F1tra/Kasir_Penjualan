<?php

namespace App\Http\Controllers;

use App\Models\Mbarang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;


class MbarangController extends Controller
{
   
    public function index()
    {
        $barang = Mbarang::all();
        return view('master_barang.index', compact('barang'));
    }
    // create menambahkan data
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
// edit
    public function edit($id)
    {
        $barang = Mbarang::find($id);
        return view('master_barang.edit', compact('barang'));
    }
    //update
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
    //show pada master barang
    public function show($id)
    {
        $barang = Mbarang::find($id);
        return view('master_barang.show', compact('barang'));
    }
    //menghapus pada master barang
    public function destroy($id)
    {
        $barang = Mbarang::find($id);
        $barang->delete();
        Alert::success('Berhasil', 'Menghapus Data Barang');
        return redirect('/master-barang');
    }
    public function pdf()
    {
        $barang = Mbarang::all();
        $pdf = PDF::loadview('master_barang.pdf', compact('barang'));
        return $pdf->stream('master_barang.pdf');
    }
    public function pdf_detail($id)
    {
        $barang = Mbarang::find($id);
        $pdf = PDF::loadview('master_barang.pdf_detail', compact('barang'));
        return $pdf->stream('master_barang_detail.pdf');
    }



}