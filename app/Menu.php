<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menu";
    protected $primaryKey = 'id';
    protected $fillable = ['id_kategori','nama','harga', 'deskripsi','stok','gambar','created_at','updated_at'];
}
