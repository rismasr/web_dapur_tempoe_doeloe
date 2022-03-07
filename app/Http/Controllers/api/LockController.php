<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LockController extends Controller
{
    public function lockMeja(Request $request){
        $meja = \DB::table('meja')
        ->where('meja.no', $request->no)
        ->first();
        if($meja == null){
            return response()->json(['error' => true, 'message' => 'Meja Belum Terdaftar']);
        }else{
            return response()->json([
                'error' => false,
                'message' => 'Sukses Kunci Meja',
                'data' => $meja
            ]);
        }
    }
}
