<?php

namespace App\Exports;

use App\OrdersModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Meja;
use App\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     // return Menu::all();

    //     // $data = DB::table('orders')
    //     // ->select('orders.id','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
    //     // ->where('orders.status', '2')
    //     // ->where('orders.checkout', 1)
    //     // ->join('menu','menu.id','orders.id_menu')
    //     // ->join('meja','meja.id','orders.id_meja')
    //     // ->get();
    //     // $exel = ('laporan_transaksi.transaksipdf', ['transaksi' => $data])->setPaper('A4','potrait');
    //     // return $pdf->stream();
    // }

    protected $dariTgl, $sampaiTgl;

    public function __construct($dariTgl, $sampaiTgl)
    {   
        $this->dariTgl = $dariTgl;   
        $this->sampaiTgl = $sampaiTgl;    
    }

    public function view(): View
    {
        $data['transaksi'] = DB::table('orders')
                    ->select('orders.id','orders.no_pesanan as no_pesanan','menu.nama as menu_nama', 'menu.harga as harga','menu.created_at','meja.no as meja_no','orders.amount','orders.status','orders.created_at','orders.updated_at')
                    ->where('orders.status', '2')
                    ->where('orders.checkout', 1)
                    ->whereDate('orders.created_at', '>=', $this->dariTgl)
                    ->whereDate('orders.created_at', '<=', $this->sampaiTgl)
                    ->join('menu','menu.id','orders.id_menu')
                    ->join('meja','meja.id','orders.id_meja')
                    ->get();

        return view('laporan_transaksi.transaksiexcel')->with($data);
    }
}
