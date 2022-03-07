<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function chartOrder(){
        
        $menu_terjual = \DB::table('menu')
        ->select(\DB::raw("menu.menu_terjual as menu_terjual"))
        ->whereYear('menu.created_at', date('Y'))
        ->pluck('menu_terjual');
  
        $nama_menu = \DB::table('menu')
        ->select(\DB::raw("menu.nama as nama_menu"))
        ->whereYear('menu.created_at', date('Y'))
        ->pluck('nama_menu');    
        return view('grafik_menu_terlaris.index', compact('menu_terjual','nama_menu'));
    }
}
