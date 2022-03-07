@extends('user.master')
@section('content')
            <div class="row">
              <div class="col-12 col-md-6 col-lg-10">
                <div class="card">
                  <form  enctype="multipart/form-data" method="POST" action="{{ route('users.store') }}">
                  @csrf
                    <div class="card-header">
                      <h4>Create Users</h4>
                    </div>
                    @if(session('errors'))
                    <div class="alert alert-danger alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                      </div>
                    </div>
                    @endif
                    <div class="card-body">
                      <div class="form-group">
                        <label>Nama </label>
                        <input id="name" name="name" type="text" placeholdrer="masukan nama" class="form-control" required="">
                        <div class="invalid-feedback">
                         nama kosong
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label>Username</label>
                        <input id="email" name="email" type="text" placeholdrer="masukan username" class="form-control" required="">
                        <div class="invalid-feedback">
                         username kosong
                        </div>
                      </div>
                    
                      <div class="form-group">
                       <label>Password </label>
                        <input id="password" name="password" type="password" placeholdrer="masukan password" class="form-control" required="">
                        <div class="invalid-feedback">
                         password kosong
                        </div>
                      </div>
                    
                      <div class="form-group">
                       <label>Konfirmasi Password </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholdrer="masukan konfirmasi password" class="form-control">
                        <div class="invalid-feedback">
                         nama kosong
                        </div>
                      </div>
                      
                       <div class="form-group">
                        <label>Pilih Role</label>
                          <select name="group_id" class="form-control">
                            <option value="">--Pilih Role--</option>
                            @foreach ($roles as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                          </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputImage">Gambar</label>
                        <div class="col-md-6 col-sm-6 ">
                        <input type="file" name="picture" />
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
@endsection
