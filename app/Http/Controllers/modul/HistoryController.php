<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OrdersModel;

class HistoryController extends Controller
{
    
    public function index()
    {
        $data['transaksi'] = \DB::table('orders')
        ->select('orders.id','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->where('orders.deleted_at', '0')
        ->join('menu','menu.id','orders.id_menu')
        ->join('meja','meja.id','orders.id_meja')
        ->get();
        return view('history_transaksi.index')->with($data);
    }
    public function destroy($id){
        $del = OrdersModel::find($id);
        $del->delete();      
        return redirect('historyTransaksi');
    }
}
