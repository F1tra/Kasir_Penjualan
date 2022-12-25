<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tpembelianbarang extends Model
{
    protected $table = 'transaksi_pembelian_barang';
    protected $fillable = ["transaksi_pembelian_id", "master_barang_id", "jumlah", "harga_satuan"];
    use HasFactory;
}