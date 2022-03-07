<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembayaranMeja extends Model
{
    protected $table = "pembayaran_meja";
    protected $primaryKey = 'id_pembayaran_meja';
    protected $fillable = ['id_meja','no_pesanan','total','uangmasuk','kembalian','created_at','updated_at'];

}
