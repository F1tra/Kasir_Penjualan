<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Mbarang;
use App\Models\Tpembelianbarang;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Mbarang::create([
            'nama_barang' => 'Sabun batang',
            'harga_satuan' => '3000',
        ]);

        Mbarang::create([
            'nama_barang' => 'Mi Instan',
            'harga_satuan' => '2000',
        ]);

        Mbarang::create([
            'nama_barang' => 'Pensil',
            'harga_satuan' => '1000',
        ]);

        Mbarang::create([
            'nama_barang' => 'Kopi sachet',
            'harga_satuan' => '1500',
        ]);

        Mbarang::create([
            'nama_barang' => 'Air minum galon',
            'harga_satuan' => '20000',
        ]);
        //Barang
        // pembelian barang
        Tpembelianbarang::create([
            'transaksi_pembelian_id' => 2,
            'master_barang_id' => 5,
            'jumlah' => 8,
            'harga_satuan' => 20000,
        ]);
    }
}