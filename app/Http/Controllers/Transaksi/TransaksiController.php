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
class TransaksiController extends Controller
{ 
     public function index(Request $request)
    {
        // $id_meja = Meja::all();
        $data['cari'] = $request->cari;
        $data['transaksi'] = DB::table('orders')
        ->select('orders.id','menu.nama as menu_nama', 'orders.no_pesanan as no_pesanan', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->where('orders.deleted_at', 1)
        ->where('orders.checkout', 1)
        ->where('orders.status', '!=', 2)
        ->join('menu','menu.id','orders.id_menu')
        ->join('meja','meja.id','orders.id_meja')
        ->get();
        
        return view('transaksi.index')->with($data);
    }
    

    public function detailTransaksi($id){
        $data['transaksi'] = DB::table('orders')
        ->select('orders.id','menu.nama as menu_nama', 'orders.no_pesanan as no_pesanan', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->where('orders.deleted_at', '1')
        ->where('orders.checkout', 1)
        ->where('orders.id',$id)
        ->join('menu','menu.id','orders.id_menu')
        ->join('meja','meja.id','orders.id_meja')
        ->get();
        return view('transaksi.detail')->with($data);
    }

    public function cari(Request $request)
	{
        $cari = $request->cari;
        if(isset($_POST['search']))
		{
            $data['transaksi'] = DB::table('orders')
            ->select('orders.id','orders.id_meja','menu.nama as menu_nama', 'orders.no_pesanan as no_pesanan', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
            ->join('menu','menu.id','orders.id_menu')
            ->join('meja','meja.id','orders.id_meja')
            ->where('orders.checkout', 1)
            ->where('orders.status', '!=', 2)
            ->where('meja.no','like','%'.$cari.'%')
            ->where('orders.deleted_at', '1')
            ->get();
            return view('transaksi.index')->with($data);

        }else if(isset($_POST['print'])){
            $data = DB::table('pembayaran_meja')
            ->select('orders.id_meja', 'orders.no_pesanan as no_pesanan','pembayaran_meja.total as total','pembayaran_meja.uangmasuk as bayar','pembayaran_meja.kembalian as kembalian','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
            ->join('orders','orders.id_meja','pembayaran_meja.id_meja')
            ->join('meja','meja.id','pembayaran_meja.id_meja')
            ->join('menu','menu.id','orders.id_menu')
            ->where('orders.checkout', 1)
            ->where('orders.status', 3)
            ->where('meja.no','like','%'.$cari.'%')
            ->where('orders.deleted_at', '1')
            ->get();
            $pdf = PDF::loadView('transaksi.pembayaranpdfmeja', ['transaksi' => $data])->setPaper('A4','potrait');
            return $pdf->stream();

        }else if(isset($_POST['bayar'])){

            $getMax = DB::table('orders')
            ->select('orders.id', 'orders.id_meja', 'meja.no as meja_no')
            ->join('meja','meja.id','orders.id_meja')
            ->where('meja.no', $cari)
            ->max('orders.no_pesanan');

             $data['transaksi'] = DB::table('orders')
            ->select('orders.id','orders.id_meja','menu.nama as menu_nama', 'orders.no_pesanan as no_pesanan', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
            ->join('menu','menu.id','orders.id_menu')
            ->join('meja','meja.id','orders.id_meja')
            ->where('orders.checkout', 1)
            ->where('orders.status', 3)
            ->where('orders.no_pesanan', $getMax) // ini 
            ->where('meja.no',$cari)
            ->where('orders.deleted_at', '1')
            ->get(); 

            // jadi mau kenapa bisane ora muncul ng kene where e berdasarkan no_pesanan == $getMax
            // $getMax kan brrti kue nomor maksimal dari nomor pesanan dadine ora muncul 
            // mulane mau tak ganti 1 ndisit dadi ne sing no_pesanan 2 diproses krn nomor maksimal
            
            return view('transaksi.bayar_per_Meja')->with($data);
        }

	}

    public function report()
    {
        $data['transaksi'] = DB::table('orders')
        ->select('orders.id', 'orders.no_pesanan as no_pesanan','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->where('orders.status', '2')
        ->where('orders.checkout', 1)
        ->join('menu','menu.id','orders.id_menu')
        ->join('meja','meja.id','orders.id_meja')
        ->get();
        return view('Laporan_transaksi.index')->with($data);
    }
    public function cetakpdf(Request $request){
        $data = DB::table('orders')
        ->select('orders.id','orders.no_pesanan as no_pesanan','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->where('orders.status', '2')
        ->where('orders.checkout', 1)
        ->whereDate('orders.created_at', '>=', $request->dari_tgl)
        ->whereDate('orders.created_at', '<=', $request->sampai_tgl)
        ->join('menu','menu.id','orders.id_menu')
        ->join('meja','meja.id','orders.id_meja')
        ->get();
        $pdf = PDF::loadView('laporan_transaksi.transaksipdf', ['transaksi' => $data])->setPaper('A4','potrait');
        return $pdf->stream();
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
        return view('transaksi.create', compact('menu','meja'));
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

        $getMax = DB::table('orders')
                ->select('orders.id', 'orders.id_meja', 'meja.no as meja_no')
                ->join('meja','meja.id','orders.id_meja')
                // ->where('meja.id', $request->id_meja)
                ->max('orders.no_pesanan');

        $data = [
             'id_menu'      =>$request->id_menu,
             'id_meja'      =>$request->id_meja,
             'amount'       =>$request->amount,
             'status'       => 0,
             'checkout'     => 1,
             'no_pesanan' => $getMax+1,
             'deleted_at'   => 1,
        ];

         $transaksi = OrdersModel::create($data);

         if($transaksi){
            Session::flash('success', 'Create Transaksi berhasil');
            return redirect()->route('transaksi.index');
        } else {
            Session::flash('errors', ['' => 'Create Transaksi gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('transaksi.create');
        }
        return redirect()->route('transaksi.index');
     }

       public function approve(Request $request, $id)
    {
        $transaksi = OrdersModel::find($id);
        $transaksi->status = $request->status;
        if ($request->status == 5) {
            $transaksi->deleted_at = 0;
        }

        if ($transaksi->save()) {
            Session::flash('success', 'Sukses! Berhasil perbarui data');
        } else {
            Session::flash('errors', 'Error! Gagal hapus data.');
        }
            
        return redirect()->route('transaksi.index');
    }


    public function selesai(Request $request, $id)
    {
        $transaksi = OrdersModel::find($id);
        $transaksi->status = $request->status;
        if ($request->status == 6) {
            $transaksi->deleted_at = 0;
        }

        if ($transaksi->save()) {
            Session::flash('success', 'Sukses! Berhasil perbarui data');
        } else {
            Session::flash('errors', 'Error! Gagal hapus data.');
        }
            
        return redirect()->route('transaksi.index');
    }

    public function tolak(Request $request, $id)
    {
        $transaksi = OrdersModel::find($id);
        $transaksi->status = $request->status;
        if ($request->status == 7) {
            $transaksi->deleted_at = 0;
        }

        if ($transaksi->save()) {
            Session::flash('success', 'Sukses! Berhasil perbarui data');
        } else {
            Session::flash('errors', 'Error! Gagal hapus data.');
        }
            
        return redirect()->route('transaksi.index');
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
        return view('transaksi.show')->with($data);
    }

    public function export_excel(Request $request)
	{
        $lapObj = new LaporanExport($request->dari_tgl, $request->sampai_tgl);

        return Excel::download($lapObj, 'Laporanpenjualan.xlsx');
        
	}

}
