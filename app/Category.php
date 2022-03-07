<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "kategori";
    protected $primaryKey = 'id';
    protected $fillable = ['nama','created_at', 'updated_at'];
}
