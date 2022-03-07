<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Menu;

class MenuController extends Controller
{
    public function getMakanan(){
        $menu = \DB::table('menu')
        ->select('menu.id', 'menu.id_kategori', 'menu.nama', 'menu.harga', 'menu.deskripsi',
         'menu.stok', 'menu.gambar', 'menu.created_at', 'menu.updated_at')
        ->where('menu.id_kategori', 1)
        ->get();
        return response([
            'status' => true,
            'menu'   => $menu
        ], 200);
    }

    public function getMinuman(){
        $menu = \DB::table('menu')
        ->select('menu.id', 'menu.id_kategori', 'menu.nama', 'menu.harga', 'menu.deskripsi',
         'menu.stok', 'menu.gambar', 'menu.created_at', 'menu.updated_at')
        ->where('menu.id_kategori', 2)
        ->get();

        return response([
            'status' => true,
            'menu'   => $menu
        ], 200);
    }
}
