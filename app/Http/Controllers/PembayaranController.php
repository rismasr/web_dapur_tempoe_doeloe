<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\PembayaranMeja;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Session;
use App\OrdersModel;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function store(Request $request, $id_meja)
     {
        $rules = [
            'uangmasuk'                      => 'required',
            ];
        $messages = [
            'uangmasuk.required'         => 'Uang Masuk wajib diisi',
            ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
             'id_meja'          =>$id_meja,
             'no_pesanan'       => $request->no_pesanan,
             'total'            => $request->grand_total,
             'uangmasuk'        =>$request->uangmasuk,
             'kembalian'        => $request->uangkembalian
        ];
        $transaksi = PembayaranMeja::create($data);

         if($transaksi){
            $up =  OrdersModel::where('id_meja',$id_meja);
            $up->update([
                'status'=>2
            ]);
            
            return $this->cetakStruk($id_meja, $request->no_pesanan, $transaksi->id_pembayaran_meja);

            Session::flash('success', 'Berhasil Melakukan Pembayaran');
            return redirect()->route('transaksi.index');
        } else {
            Session::flash('errors', ['' => 'Pembayaran Gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('transaksi.create');
        }

        
        return redirect()->route('transaksi.index');
     }

     public function cetakStruk($id_meja, $no_pesanan, $id_pembayaran){
        $getMax = DB::table('orders')
        ->select('orders.id', 'orders.id_meja', 'meja.no as meja_no')
        ->join('meja','meja.id','orders.id_meja')
        ->where('meja.id', $id_meja)
        ->max('orders.no_pesanan');

        $data = DB::table('pembayaran_meja')
        ->select('orders.id_meja', 'orders.no_pesanan as no_pesanan','pembayaran_meja.total as total','pembayaran_meja.uangmasuk as bayar','pembayaran_meja.kembalian as kembalian','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        ->join('orders','orders.id_meja','pembayaran_meja.id_meja')
        ->join('meja','meja.id','pembayaran_meja.id_meja')
        ->join('menu','menu.id','orders.id_menu')
        ->where('orders.no_pesanan', $no_pesanan)
        ->where('orders.checkout', 1)
        ->where('meja.id', $id_meja)
        ->where('orders.deleted_at', '1')
        ->where('pembayaran_meja.id_pembayaran_meja', $id_pembayaran)
        ->get();

        $pdf = PDF::loadView('transaksi.pembayaranpdfmeja', ['transaksi' => $data])->setPaper('A4','potrait');
        return $pdf->stream('pembayaran.pdf', ['Attachment' => false]);

        // $data = DB::table('pembayaran_meja')
        // ->select('orders.id_meja', 'orders.no_pesanan as no_pesanan','pembayaran_meja.total as total','pembayaran_meja.uangmasuk as bayar','pembayaran_meja.kembalian as kembalian','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
        // ->join('orders','orders.id_meja','pembayaran_meja.id_meja')
        // ->join('meja','meja.id','pembayaran_meja.id_meja')
        // ->join('menu','menu.id','orders.id_menu')
        // // ->where('orders.no_pesanan', $getMax)
        // ->where('orders.checkout', 1)
        // ->where('orders.status', 3)
        // ->where('meja.id','like','%'.$id_meja.'%')
        // ->where('orders.deleted_at', '1')
        // ->get();
        
        // $pdf = PDF::loadView('transaksi.pembayaranpdfmeja', ['transaksi' => $data])->setPaper('A4','potrait');
        // return $pdf->stream();
     }

     public function store2(Request $request, $id_meja, $id)
     {
        $rules = [
            'uangmasuk'                      => 'required',
            ];
        $messages = [
            'uangmasuk.required'         => 'Uang Masuk wajib diisi',
            ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
             'id_meja'          => $id_meja,
             'total'            => $request->grand_total,
             'uangmasuk'        =>$request->uangmasuk,
             'kembalian'        => $request->uangkembalian
        ];
         $transaksi = PembayaranMeja::create($data);

         if($transaksi){
            $up =  OrdersModel::where('id',$id);
            $up->update([
                'status'=>2
            ]);
            Session::flash('success', 'Berhasil Melakukan Pembayaran');
            return redirect()->route('transaksi.index');
        } else {
            Session::flash('errors', ['' => 'Pembayaran Gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('transaksi.create');
        }
        return redirect()->route('transaksi.index');
     }
}
