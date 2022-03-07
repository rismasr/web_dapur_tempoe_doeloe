<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Meja;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class MejaController extends Controller
{
    public function index(){
        $meja=Meja::all();
        return view('meja.index', compact('meja'));
    }
    public function addMeja(){
        return view('meja.add_meja');
    }
    public function edit($id){
        $meja=Meja::find($id);
        return view('meja.update_meja',compact('meja'));
    }
    public function updatemeja (Request $request, $id){
        $up = Meja::findOrFail($id);
        $up->update([
            'no'=>$request->no
        ]);
        if($up){
            Session::flash('success', 'Edit Meja berhasil');
            return redirect('meja');
        } else {
            Session::flash('errors', 'Edit Meja gagal!');
            return redirect('edit');
        }
        return redirect('meja');
    }
    public function store(Request $request)
    {
        $rules = [
            'no'                      => 'required'
        ];
        $messages = [
            'no.required'         => 'No Meja wajib diisi',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

         $meja = Meja::create([
             'no'=>$request->no
         ]);

         if($meja){
            Session::flash('success', 'Tambah Meja berhasil');
            return redirect('meja');
        } else {
            Session::flash('errors', 'Tambah Meja gagal!');
            return redirect('addMeja');
        }
        return redirect('meja');
    }
    public function destroy($id){
        $del = Meja::find($id);
        $del->delete();      
        return redirect('meja');
    }
}
