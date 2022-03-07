<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    protected $table = "orders";
    protected $primaryKey = 'id';
    protected $fillable = ['id_menu','id_meja','no_pesanan','amount','jumlah', 'status', 'checkout','uangmasuk', 'created_at', 'updated_at', 'deleted_at'];

     public function menu()
    {
        return $this->belongsTo('App\Menu','id_menu','id');
    }

    public function meja()
    {
        return $this->belongsTo('App\Meja','id_meja','id');
    }
}
