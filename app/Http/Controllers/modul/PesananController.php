<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
// use PDF;
use App\Meja;
use App\Menu;
use App\OrdersModel;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;
class PesananController extends Controller
{ 
     public function index(Request $request)
    {
        // $id_meja = Meja::all();
        $data['cari'] = $request->cari;
        $data['transaksi'] = DB::table('orders')
        ->select('orders.id','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->where('orders.deleted_at', 1)
        ->where('orders.checkout', 1)
        ->join('menu','menu.id','orders.id_menu')
        ->join('meja','meja.id','orders.id_meja')
        ->get();
        return view('pesanan.index')->with($data);
    }

    public function detailTransaksi($id){
        $data['transaksi'] = DB::table('orders')
        ->select('orders.id','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->where('orders.deleted_at', '1')
        ->where('orders.checkout', 1)
        ->where('orders.id',$id)
        ->join('menu','menu.id','orders.id_menu')
        ->join('meja','meja.id','orders.id_meja')
        ->get();
        return view('pesanan.detail')->with($data);
    }

    public function cari(Request $request)
	{
        $cari = $request->cari;
        if(isset($_POST['search']))
		{
            $data['transaksi'] = DB::table('orders')
            ->select('orders.id','orders.id_meja','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
            ->join('menu','menu.id','orders.id_menu')
            ->join('meja','meja.id','orders.id_meja')
            ->where('orders.checkout', 1)
            ->where('meja.no','like','%'.$cari.'%')
            ->where('orders.deleted_at', '1')
            ->get();
            return view('pesanan.index')->with($data);
        }

	}

    // public function report()
    // {
    //     $data['transaksi'] = DB::table('orders')
    //     ->select('orders.id','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
    //     ->where('orders.status', '2')
    //     ->where('orders.checkout', 1)
    //     ->join('menu','menu.id','orders.id_menu')
    //     ->join('meja','meja.id','orders.id_meja')
    //     ->get();
    //     return view('Laporan_transaksi.index')->with($data);
    // }
    // public function cetakpdf(){
    //     $data = DB::table('orders')
    //     ->select('orders.id','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
    //     ->where('orders.status', '2')
    //     ->where('orders.checkout', 1)
    //     ->join('menu','menu.id','orders.id_menu')
    //     ->join('meja','meja.id','orders.id_meja')
    //     ->get();
    //     $pdf = PDF::loadView('laporan_transaksi.transaksipdf', ['transaksi' => $data])->setPaper('A4','potrait');
    //     return $pdf->stream();
    // }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $menu = Menu::all();
    //     $meja = Meja::all();
    //     return view('transaksi.create', compact('menu','meja'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  public function store(Request $request)
    //  {
    //       $rules = [
    //         'id_menu'                      => 'required',
    //         'id_meja'                      => 'required',
    //         'amount'                      => 'required',
    //         'status'                      => 'required'
    //     ];
    //     $messages = [
    //         'id_menu.required'         => 'No Menu wajib diisi',
    //         'id_menu.required'         => 'No Meja wajib diisi',
    //         'amount.required'         => 'No Harga wajib diisi',
    //         'status.required'         => 'No Status wajib diisi'
    //     ];
 
    //     $validator = Validator::make($request->all(), $rules, $messages);
 
    //     if($validator->fails()){
    //         return redirect()->back()->withErrors($validator)->withInput($request->all);
    //     }

    //     $data = [
    //          'id_menu'      =>$request->id_menu,
    //          'id_meja'      =>$request->id_meja,
    //          'amount'       =>$request->amount,
    //          'status'       => $request->status
    //     ];
    //      $transaksi = OrdersModel::create($data);

    //      if($transaksi){
    //         Session::flash('success', 'Create Transaksi berhasil');
    //         return redirect()->route('transaksi.index');
    //     } else {
    //         Session::flash('errors', ['' => 'Create Transaksi gagal! Silahkan ulangi beberapa saat lagi']);
    //         return redirect()->route('transaksi.create');
    //     }
    //     return redirect()->route('transaksi.index');
    //  }

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
            
        return redirect()->route('pesanan.index');
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
            
        return redirect()->route('pesanan.index');
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
            
        return redirect()->route('pesanan.index');
    }

    //   public function bayar(Request $request, $id)
    // {
    //     $transaksi = OrdersModel::find($id);
    //     $transaksi->status = $request->status;
    //     if ($request->status == 2) {
    //         $transaksi->deleted_at = 0;
    //     }

    //     if ($transaksi->save()) {
    //         Session::flash('success', 'Sukses! Berhasil perbarui data');
    //     } else {
    //         Session::flash('errors', 'Error! Gagal hapus data.');
    //     }
            
    //     return redirect()->route('transaksi.index');
    // }

    public function deleted(Request $request, $id)
    {
        $transaksi = OrdersModel::find($id);
        $transaksi->deleted_at = 0;

        if ($transaksi->save()) {
            Session::flash('success', 'Sukses! Berhasil hapus data');
        } else {
            Session::flash('errors', 'Error! Gagal hapus data.');
        }
            
        return redirect()->route('pesanan.index');
    }

    // public function show($id)
    // {
    //     $data['transaksi'] = DB::table('orders')
    //     ->select('orders.id','orders.id_meja','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
    //     ->where('orders.deleted_at', 1)
    //     ->where('orders.id',$id)
    //     ->where('orders.checkout', 1)
    //     ->join('menu','menu.id','orders.id_menu')
    //     ->join('meja','meja.id','orders.id_meja')
    //     ->get();
    //     return view('transaksi.show')->with($data);
    // }

//    public function update (Request $request, Menu $menu, $id){
//         $up = OrdersModel::findOrFail($id);
//         $up->update([
//             'uangmasuk'=>$request->uangmasuk,
//             'status'=>2
//         ]);
//         $id_user = Auth::user()->id;

//         return redirect('transaksi');
//     }
}
