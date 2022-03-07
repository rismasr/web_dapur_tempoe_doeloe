<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index(){
        $id_user = Auth::user()->id;
        $profile= User::find($id_user);
        return view('profile.index', compact('profile'));
    }
    public function updateDataProfile (Request $request){
        $id_user = Auth::user()->id;
        $up = User::findOrFail($id_user);
        $up->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);
        if($up->save()){
            Session::flash('success', 'Ubah Data Profil berhasil!');
            return redirect('profile');
        }else{
            Session::flash('error', 'Ubah Data Profil gagal!');
            return redirect('profile');
        }
        return redirect('profile');
    }
    public function updatepicture (Request $request){
        $id = Auth::user()->id;
        $up = User::findOrFail($id);
        if($request->picture){
            $image = time().'.'.$request->picture->extension();
            $request->picture->move(public_path('assets/profile'), $image);
        }
        else{
            $user= User::findOrFail($id);
            $image=$user->picture;
        }
        if(File::exists(public_path('assets/profile/'.$up->picture))){
           File::delete(public_path('assets/profile/'.$up->picture));
        }
        $up->update([
            'picture'=>$image
        ]);
        if($up->save()){
            Session::flash('success', 'Ubah Foto Profil berhasil!');
            return redirect('profile');
        }else{
            Session::flash('error', 'Ubah Foto Profil gagal!');
            return redirect('profile');
        }
        return redirect('profile');
    }
    public function changePassword(Request $request){
        $rules = [
            'old_password'          => 'required',
            'password'              => 'required|confirmed'
        ];
 
        $messages = [
            'old_password.required' => 'Password Lama wajib diisi',
            'password.required'     => 'Password Baru wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];

         $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $old_password = auth()->user()->password;

        $user_id = auth()->user()->id;

        if(Hash::check($request->input('old_password'), $old_password)){
            $user = User::find($user_id);

            $user->password = Hash::make($request->input('password'));

            if($user->save()){
                Session::flash('success', 'Change Password berhasil!');
                return redirect('profile');
            }
        }else{
            Session::flash('error', 'Change Password gagal!');
            return redirect('profile');
        }
    }
}
