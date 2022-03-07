<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class StokController extends Controller
{
    public function index()
    {
         $menu=Menu::all();
        return view('stok.index', compact('menu'));
    }

       public function edit($id)
    {
        $menu=Menu::find($id);
        return view('stok.edit',compact('menu'));
    }
    public function updatestok (Request $request, Menu $menu, $id){
        $up = Menu::findOrFail($id);
        $up->update([
            'stok'=>$request->stok
        ]);
        
        $id_user = Auth::user()->id;
        if($up->save()){
            Session::flash('success', 'Ubah User Role berhasil!');
            return redirect('stok');
        }else{
            Session::flash('error', 'Ubah User Role gagal!');
            return redirect('edit');
        }
        return redirect('stok');
    }
}
