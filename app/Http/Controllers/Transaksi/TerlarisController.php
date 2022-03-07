<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TerlarisController extends Controller
{
    public function index()
    {
        $data['laris'] = DB::table('menu')
        ->select('*')
        ->orderBy('menu_terjual','desc')
        ->get();
        return view('terlaris.menu_terlaris')->with($data);

    }
}
