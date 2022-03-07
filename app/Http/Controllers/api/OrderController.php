<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\OrdersModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function addOrder(Request $request){
        $orders_menu = new OrdersModel;
        $orders_menu->id_menu = $request->id_menu;
        $orders_menu->id_meja = $request->id_meja;
        $orders_menu->amount = $request->jumlah;
        $orders_menu->status = 0;
        $orders_menu->checkout = 0;
        $orders_menu->deleted_at = 1;
        $orders_menu->save();

        if($orders_menu){
            return response([
                'kode' => 1,
                'pesan' => 'Sucess Add to Cart'
            ], 200);
        }else{
            return response([
                'kode' => 2,
                'pesan' => 'Gagal Add to Cart'
            ], 400);
        }
    }
    public function checkoutPesanan(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'id_meja'     => 'required'
        ],
            [
                'id_meja.required' => 'Masukkan id Meja Post !'
            ]
        );

        if($validator->fails()) {
            return response([
                'kode' => 3,
                'pesan' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $getMax = DB::table('orders')
                ->select('orders.id', 'orders.id_meja', 'meja.no as meja_no')
                ->join('meja','meja.id','orders.id_meja')
                // ->where('meja.id', $request->id_meja)
                ->max('orders.no_pesanan');
                
            $post = OrdersModel::where('id_meja',$request->input('id_meja'))
                ->where('deleted_at',1)
                ->where('checkout',0)
                ->update([
                    'checkout'     => 1,
                    'no_pesanan' => $getMax+1
                ]);

            if ($post) {
                return response([
                    'kode' => 1,
                    'pesan' => 'Sucess Checkout Pesanan'
                ], 200);
            } else {
                return response([
                    'kode' => 2,
                    'pesan' => 'Gagal Checkout Pesanan'
                ], 400);
            }
        }
    }
    public function getPesananByMeja(Request $request){
        $pesanan = DB::table('orders')
            ->select('orders.id','orders.id_meja','menu.nama as nama', 'menu.harga as harga','meja.no as no_meja','orders.amount as jumlah','orders.status','orders.checkout')
            ->join('menu','menu.id','orders.id_menu')
            ->join('meja','meja.id','orders.id_meja')
            ->where('meja.no',  $request->no_meja)
            ->where('orders.checkout',  0)
            ->where('orders.deleted_at', '1')
            ->get();

        return response([
            'pesanan' => $pesanan,
            'message' => "Success Load Pesanan",
            'success' => true
        ], 200);
    }

    public function tolakPesanan(Request $request, $id)
    {
        $transaksi = OrdersModel::find($id);
        $transaksi->status = $request->status;
        if ($request->status == 7) {
            $transaksi->deleted_at = 0;
        }

        if ($transaksi->save()) {
            return response([
                'message' => "Sukses! Berhasil perbarui data",
                'success' => true
            ], 200);
        } else {
            return response([
                'message' => "Error! Gagal hapus data.",
                'success' => false
            ], 500);
        }
    }
}
