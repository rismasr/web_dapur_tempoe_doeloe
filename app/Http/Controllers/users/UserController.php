<?php

namespace App\Http\Controllers\users;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{ 
    
    public function index()
    {
        $account = DB::table('users_groups')
        ->select('users.name', 'users.email','users.id', 'groups.name as nama_role')
        ->join('users','users.id','users_groups.user_id')
        ->join('groups','groups.id', 'users_groups.group_id')
        ->get();

        return view('user.index', compact('account'));
    }

    public function detailUsers($id_user){
        $users = User::find($id_user);
        return view('user.detail',compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
         $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|unique:users,email',
            'password'              => 'required|confirmed',
            'picture'               => 'required|image|mimes:jpeg,bmp,png',
        ];
 
        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
        ];
        $uploadThumbnail = $request->file('picture');
        if (!empty($uploadThumbnail)) {
            $thumbnail = time() . Str::random(22) . '.' . $uploadThumbnail->getClientOriginalExtension();
            $destinationPath = public_path('assets/profile');
            $img = Image::make($uploadThumbnail->path());
            $img->resize(700, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '' . $thumbnail, 50);
        }

        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $user = User::create([
            'name'              => ucwords(strtolower($request->name)),
            'email'             => strtolower($request->email),
            'password'          => bcrypt($request->password),
            'remember_token'    => Str::random(50),
            'picture'     => $thumbnail,
        ]);
   
        // $user->role()->attach(Role::all());
        $user->role()->sync($request['group_id']);
        if($user){
            Session::flash('success', 'Tambah User berhasil');
            return redirect()->route('users.index');
        } else {
            Session::flash('errors', 'Tambah User gagal!');
            return redirect()->route('users.create');
        }
    }

    public function show($id)
    {
         $data['account'] = User::findOrFail($id);
        return view('user.detail')->with($data);
    }

      public function edit($id)
    {
        $account = User::findOrFail($id);
        return view('user.edit',compact('account'));
    }

    public function update(Request $request, $id)
    {
        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $uploadThumbnail = $request->file('picture');
        if (!empty($uploadThumbnail)) {
            $thumbnail = time() . Str::random(22) . '.' . $uploadThumbnail->getClientOriginalExtension();
            $destinationPath = public_path('assets/profile');
            $img = Image::make($uploadThumbnail->path());
            $img->resize(700, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $thumbnail, 50);

            //hapus file
            File::delete(public_path('assets/profile') . '/' . $users->picture);
            $users->picture = $thumbnail;
        }
        $users->save();
        return redirect()->route('users.index');
    }


    public function changePassword(Request $request, $id){

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

        $users = User::find($id);
        $old_password = $users->password;
       

        if(Hash::check($request->input('old_password'), $old_password)){
            $user = User::find($id);

            $user->password = Hash::make($request->input('password'));

            if($user->save()){
                Session::flash('success', 'Ubah Password berhasil!');
                return redirect()->route('users.index');
            }
        }else{
            Session::flash('error', 'Ubah Password gagal!');
            return redirect()->route('users.index');
        }
    }    

    // public function destroy($id)
    // {
    //        $admin = User::findOrFail($id);
    //     if ($admin->delete()) {
    //          Session::flash('success', 'Sukses! Berhasil hapus data');
    //     } else {
    //         Session::flash('errors', 'Error! Gagal hapus data.');
    //     }
    //         return redirect()->route('admin.index');
    //     }

    public function destroy($id){
        $del = User::find($id);
        if(File::exists(public_path('assets/profile/'.$del->picture))){
            File::delete(public_path('assets/profile/'.$del->picture));
        }
        $del->delete();      
        return redirect()->route('users.index');
    }

}
