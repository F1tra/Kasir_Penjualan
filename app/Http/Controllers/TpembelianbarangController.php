<?php

namespace App\Http\Controllers;
use App\Models\Tpembelianbarang;
use Illuminate\Http\Request;
use App\Models\Tpembelian;
use App\Models\Mbarang;
use App\Exports\TpembelianbExport;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

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
    public function show($id)
    {
        $tpembelianb = TpembelianBarang::find($id);

        return view('transaksi_pembelian_barang.show', compact('tpembelianb'));
    }
    public function edit($id)
    {
        $tpembelianb = TpembelianBarang::find($id);
        $tpembelian = Tpembelian::all();
        $barang = Mbarang::all();
        return view('transaksi_pembelian_barang.edit', compact('tpembelianb', 'tpembelian', 'barang'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'transaksi_pembelian_id' => 'required',
            'master_barang_id' => 'required',
            'jumlah' => 'required',
            'harga_satuan' => 'required',
        ]);

        $tpembelianb = TpembelianBarang::find($id);

        $TpembelianBarang = [
            "transaksi_pembelian_id" => $request["transaksi_pembelian_id"],
            "master_barang_id" => $request["master_barang_id"],
            "jumlah" => $request["jumlah"],
            "harga_satuan" => $request["harga_satuan"],
        ];

        $tpembelianb2 = TpembelianBarang::find($TpembelianBarang['transaksi_pembelian_id']);
        $tpembelian = Tpembelian::find($TpembelianBarang['transaksi_pembelian_id']);

        $total_harga_baru = $request["jumlah"] * $request["harga_satuan"];
        $total_harga_lama = $tpembelianb2["jumlah"] * $tpembelianb2["harga_satuan"];

        if ($total_harga_lama < $total_harga_baru) {
            $total_harga = $total_harga_baru - $total_harga_lama;
            $seluruh_total_harga = ($tpembelian['total_harga'] + $total_harga);
            $transaksi_pembelian = [
                "total_harga" => $seluruh_total_harga,
            ];
            $tpembelian->update($transaksi_pembelian);
            $tpembelianb->update($TpembelianBarang);
            Alert::success('Berhasil', 'Mengubah Data Transaksi Pembelian Barang');
            return redirect('/transaksi-pembelian-barang');
        } elseif ($total_harga_lama > $total_harga_baru) {
            $total_harga = $total_harga_lama - $total_harga_baru;
            $seluruh_total_harga = ($tpembelian['total_harga'] - $total_harga);
            $transaksi_pembelian = [
                "total_harga" => $seluruh_total_harga,
            ];
            $tpembelian->update($transaksi_pembelian);
            $tpembelianb->update($TpembelianBarang);
            Alert::success('Berhasil', 'Mengubah Data Transaksi Pembelian Barang');
            return redirect('/transaksi-pembelian-barang');
        } elseif ($total_harga_lama == $total_harga_baru) {
            Alert::success('Berhasil', 'Mengubah Data Transaksi Pembelian Barang');
            return redirect('/transaksi-pembelian-barang');

        }
        
    }
    public function destroy($id)
    {
        $tpembelianb = TpembelianBarang::find($id);
        $tpembelian = Tpembelian::find($tpembelianb->transaksi_pembelian_id);

        $total_harga_lama = $tpembelianb["jumlah"] * $tpembelianb["harga_satuan"];
        $seluruh_total_harga = ($tpembelian['total_harga'] - $total_harga_lama);
        $transaksi_pembelian = [
            "total_harga" => $seluruh_total_harga,

        ];
        $tpembelian->update($transaksi_pembelian);
        $tpembelianb->delete();
        Alert::success('Berhasil', 'Menghapus Data Transaksi Pembelian Barang');
        return redirect('/transaksi-pembelian-barang');
    }
    public function pdf()
    {
        $tpembelianb = TpembelianBarang::all();
        $pdf = PDF::loadview('transaksi_pembelian_barang.pdf', compact('tpembelianb'));
        return $pdf->stream('transaksi_pembelian_barang.pdf');
    }
    public function pdf_detail($id)
    {
        $tpembelianb = TpembelianBarang::find($id);
        $pdf = PDF::loadview('transaksi_pembelian_barang.pdf_detail', compact('tpembelianb'));
        return $pdf->stream('transaksi_pembelian_barang_detail.pdf');
    }
    public function excel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new TpembelianbExport, 'transaksi-pembelian-barang.xlsx');
    }

   
}