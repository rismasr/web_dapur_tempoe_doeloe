<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
// use PDF;
use App\Meja;
use App\Menu;
use App\OrdersModel;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;

class TransaksiBaruController extends Controller
{ 
     public function index(Request $request)
    {
        $data['meja'] = DB::table('meja')
        ->select('meja.no')
        ->where('orders.deleted_at', 1)
        // ->where('orders.id',$id)
        ->where('orders.checkout', 1)
        ->join('orders','meja.id','orders.id_meja')
        ->get();

        
        return view('transaksi_baru.base')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu = Menu::all();
        $meja = Meja::all();
        return view('transaksi_baru.create', compact('menu','meja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
          $rules = [
            'id_menu'                      => 'required',
            'id_meja'                      => 'required',
            'amount'                      => 'required',
            'status'                      => 'required'
        ];
        $messages = [
            'id_menu.required'         => 'No Menu wajib diisi',
            'id_menu.required'         => 'No Meja wajib diisi',
            'amount.required'         => 'No Harga wajib diisi',
            'status.required'         => 'No Status wajib diisi'
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
             'id_menu'      =>$request->id_menu,
             'id_meja'      =>$request->id_meja,
             'amount'       =>$request->amount,
             'status'       => $request->status,
             'checkout'     => 1,
             'deleted_at'   => 1,
        ];

         $transaksi = OrdersModel::create($data);

         if($transaksi){
            Session::flash('success', 'Create Transaksi berhasil');
            return redirect()->route('transaksi_baru.index');
        } else {
            Session::flash('errors', ['' => 'Create Transaksi gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('transaksi_baru.create');
        }
        return redirect()->route('transaksi_baru.index');
     }

    public function show($id)
    {
        $data['transaksi'] = DB::table('orders')
        ->select('orders.id','orders.id_meja','menu.nama as menu_nama', 'orders.no_pesanan as no_pesanan', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->where('orders.deleted_at', 1)
        ->where('orders.id',$id)
        ->where('orders.checkout', 1)
        ->join('menu','menu.id','orders.id_menu')
        ->join('meja','meja.id','orders.id_meja')
        ->get();

        return view('transaksi_baru.show')->with($data);
    }

    public function export_excel(Request $request)
	{
        $lapObj = new LaporanExport($request->dari_tgl, $request->sampai_tgl);

        return Excel::download($lapObj, 'Laporanpenjualan.xlsx');
        
    }
    
    /**
     * Untuk melihat semua pesanan berdasarkan meja
     */
    public function viewMeja($idMeja)
    {
        $data['transaksi'] = DB::table('orders')
        ->select('orders.id','menu.nama as menu_nama', 'orders.no_pesanan as no_pesanan', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->where('orders.deleted_at', 1)
        ->where('orders.checkout', 1)
        ->join('menu','menu.id','orders.id_menu')
        ->join('meja','meja.id','orders.id_meja')
        ->get();
        
        return view('transaksi_baru.index')->with($data);
    }
}
