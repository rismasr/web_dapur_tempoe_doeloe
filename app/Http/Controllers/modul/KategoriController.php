<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
{
    public function index(){
        $category=Category::all();
        return view('category.index', compact('category'));
    }
    public function destroy($id){
        $del = Category::find($id);
        $del->delete();      
        return redirect('category');
    }
    public function addCategory(){
        return view('category.add_category');
    }
    public function store(Request $request)
    {
        $rules = [
            'nama'                      => 'required'
        ];
        $messages = [
            'nama.required'         => 'Nama Kategori wajib diisi',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

         $category = Category::create([
             'nama'=>$request->nama
         ]);

         if($category){
            Session::flash('success', 'Tambah Kategori berhasil');
            return redirect('category');
        } else {
            Session::flash('errors', 'Tambah Kategori gagal!');
            return redirect('addCategory');
        }
        return redirect('category');
    }
    public function edit($id){
        $category=Category::find($id);
        return view('category.update_category',compact('category'));

    }
    public function updatecategory(Request $request, $id){
        $up = Category::findOrFail($id);
        $up->update([
            'nama'=>$request->nama
        ]);
        if($up->save()){
            Session::flash('success', 'Ubah Kategori berhasil!');
            return redirect('category');
        }else{
            Session::flash('error', 'Ubah Kategori gagal!');
            return redirect('edit');
        }
        return redirect('category');
    }
}
