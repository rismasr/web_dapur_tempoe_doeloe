<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function index(){
        $menu=Menu::all();
        return view('menu.index', compact('menu'));
    }
    public function detailMenu($id){
        $menu = Menu::find($id);
        return view('menu.detail',compact('menu'));
    }
    public function addMenu()
    {
        $category = Category::all();
        return view('menu.add_menu', compact('category'));
    }
    public function store(Request $request)
    {
        $rules = [
            'nama'                      => 'required|min:3|max:35',
            'gambar'                    => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'id_kategori'               => 'required'
        ];
        $messages = [
            'nama.required'         => 'Nama Lengkap wajib diisi',
            'nama.min'              => 'Nama lengkap minimal 3 karakter',
            'nama.max'              => 'Nama lengkap maksimal 35 karakter',
            'gambar.required'       => 'Gambar wajib diisi',
            'id_kategori.required'  => 'Kategori wajib d pilih'
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $gambar = time().'.'.$request->gambar->extension();
        $request->gambar->move(public_path('assets/menu'), $gambar);
         $menu = Menu::create([
             'nama'=>$request->nama,
             'id_kategori'=> $request->id_kategori,
             'harga'=>$request->harga,
             'deskripsi'=>$request->deskripsi,
             'stok'=>$request->stok,
             'gambar'=>$gambar
         ]);

         if($menu){
            Session::flash('success', 'Tambah Menu berhasil!');
            
            $id_user = Auth::user()->id;
            
            return redirect('menu');
        } else {
            Session::flash('errors', 'Tambah Menu Gagal!');
            return redirect('addMenu');
        }

         return redirect('menu');
    }
    public function edit($id)
    {
        $menu=Menu::find($id);
        return view('menu.update_menu',compact('menu'));
    }
    public function updatemenu (Request $request, Menu $menu, $id){
        $up = Menu::findOrFail($id);
       
        if($request->gambar){
            //jika user memasukan gambar
            $image = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/menu'), $image);
            if(File::exists(public_path('assets/menu/'.$up->gambar))){
                File::delete(public_path('assets/menu/'.$up->gambar));
            }
        }
        else{
            //jika user tidak memasukan gambar
            $menu= Menu::findOrFail($id);
            $image=$menu->gambar;
        }

        $up->update([
            'nama'=>$request->nama,
            'harga'=>$request->harga,
            'deskripsi'=>$request->deskripsi,
            'stok'=>$request->stok,
            'gambar'=>$image
        ]);
        $id_user = Auth::user()->id;
        if($up->save()){
            Session::flash('success', 'Ubah Menu berhasil!');
            return redirect('menu');
        }else{
            Session::flash('error', 'Ubah Menu gagal!');
            return redirect('edit');
        }

        return redirect('menu');
    }
    public function destroy($id){
        $del = Menu::find($id);
        if(File::exists(public_path('assets/menu/'.$del->gambar))){
            File::delete(public_path('assets/menu/'.$del->gambar));
        }
        $del->delete();      
        return redirect('menu');
    }
}
