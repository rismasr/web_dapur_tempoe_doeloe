<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    public function index(){
        $role=Role::all();
        return view('role.index', compact('role'));
    }
    public function addRole(){
        return view('role.add_role');
    }
    public function store(Request $request)
    {
        $rules = [
            'name'                      => 'required'
        ];
        $messages = [
            'name.required'         => 'Nama wajib diisi',
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

         $role = Role::create([
             'name'=>$request->name
         ]);

         if($role){
            Session::flash('success', 'Tambah Role berhasil');
            return redirect('role');
        } else {
            Session::flash('errors', 'Tambah Role gagal!');
            return redirect('addRole');
        }
        return redirect('role');
    }
    public function edit($id){
        $role=Role::find($id);
        return view('role.update_role',compact('role'));
    }
    public function updaterole (Request $request, $id){
        $up = Role::findOrFail($id);
        $up->update([
            'name'=>$request->name
        ]);
        if($up->save()){
            Session::flash('success', 'Ubah User Role berhasil!');
            return redirect('role');
        }else{
            Session::flash('error', 'Ubah User Role gagal!');
            return redirect('edit');
        }
        return redirect('role');
    }
    public function destroy($id){
        $del = Role::find($id);
        $del->delete();      
        return redirect('role');
    }
}
