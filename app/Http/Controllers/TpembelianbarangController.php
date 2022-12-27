<?php

namespace App\Http\Controllers;
use App\Models\Tpembelianbarang;
use Illuminate\Http\Request;
use App\Models\Tpembelian;
use App\Models\Mbarang;
use RealRashid\SweetAlert\Facades\Alert;

class TpembelianbarangController extends Controller
{
    public function index()
    {
        $tpembelianb = TpembelianBarang::all();
        return view('transaksi_pembelian_barang.index', compact('tpembelianb'));
    }
    public function create()
    {
        $tpembelianb = TpembelianBarang::all();
        $tpembelian = Tpembelian::all();
        $barang = Mbarang::all();
        return view('transaksi_pembelian_barang.create', compact('tpembelianb', 'tpembelian', 'barang'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'transaksi_pembelian_id' => 'required',
            'master_barang_id' => 'required',
            'jumlah' => 'required',
            'harga_satuan' => 'required',
        ]);

        $data_tampung = [
            "transaksi_pembelian_id" => $request["transaksi_pembelian_id"],
            "master_barang_id" => $request["master_barang_id"],
            "jumlah" => $request["jumlah"],
            "harga_satuan" => $request["harga_satuan"],
        ];
        $total_harga = $request["jumlah"] * $request["harga_satuan"];

        if ($data_tampung["transaksi_pembelian_id"] == 0) {
            $transaksi_pembelian = Tpembelian::create([
                "total_harga" => $total_harga,
            ]);

            TpembelianBarang::create([
                "transaksi_pembelian_id" => $transaksi_pembelian->id,
                "master_barang_id" => $data_tampung["master_barang_id"],
                "jumlah" => $data_tampung["jumlah"],
                "harga_satuan" => $data_tampung["harga_satuan"]
            ]);
            Alert::success('Berhasil', 'Menambahkan Data Transaksi Pembelian Barang');
            return redirect('/transaksi-pembelian-barang');
        }

        $tpembelian = Tpembelian::find($request["transaksi_pembelian_id"]);
        $total_harga = $request["jumlah"] * $request["harga_satuan"];
        $seluruh_total_harga = ($tpembelian['total_harga'] + $total_harga);


        $data_tampung_ubah = [
            "total_harga" => $seluruh_total_harga,
        ];
        $tpembelian->update($data_tampung_ubah);

        TpembelianBarang::create([
            "transaksi_pembelian_id" => $request["transaksi_pembelian_id"],
            "master_barang_id" => $data_tampung["master_barang_id"],
            "jumlah" => $data_tampung["jumlah"],
            "harga_satuan" => $data_tampung["harga_satuan"]
        ]);
        Alert::success('Berhasil', 'Menambahkan Data Transaksi Pembelian Barang');
        return redirect('/transaksi-pembelian-barang');
    }
   
}