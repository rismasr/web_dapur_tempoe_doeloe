<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Menu;

use App\OrdersModel;
use App\PembayaranMeja;

class AuthController extends Controller
{
    public function index(){
        if(!session('berhasil_login')){
            return view('auth.login');
        }else{
            $makanan = Menu::all()->where('id_kategori',1)->count();
            $minuman = Menu::all()->where('id_kategori',2)->count();
            $total_menu =Menu::count();
            $total_orders = OrdersModel::count();   
            $status0 = OrdersModel::all()->where('status',0)->count();
            $status1 = OrdersModel::all()->where('status',1)->count();
            $status2 = OrdersModel::all()->where('status',2)->count();
            $status3 = OrdersModel::all()->where('status',3)->count();
            $status4 = OrdersModel::all()->where('status',4)->count();
            // $total_transaksi = \DB::table('orders')
            // ->select(\DB::raw("COUNT(*) as count"))
            // ->where('orders.status', 2)
            // ->whereYear('orders.created_at', date('Y'))
            // ->groupBy(\DB::raw("Month(orders.created_at)"))
            // ->pluck('count');
            
            $total_transaksi = \DB::table('pembayaran_meja')
            ->select(\DB::raw("CAST(SUM(total) as INT ) as sumtotal"))
            ->whereYear('pembayaran_meja.created_at', date('Y'))
            ->groupBy(\DB::raw("Month(pembayaran_meja.created_at)"))
            ->pluck('sumtotal');
            // dd($total_transaksi);
      
            return view('dashboard.index', compact('makanan','minuman','total_orders',
            'total_transaksi', 'status0', 'status1', 'status2', 'status3', 'status4'));
        }
    }

    public function login (Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            session(['berhasil_login' => true]);
            return redirect('/');
        }
        return redirect('/')->with('message','Username atau Password Salah');
    }
    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
