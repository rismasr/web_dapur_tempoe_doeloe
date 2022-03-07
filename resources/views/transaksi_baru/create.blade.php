@extends('menu.master')
@section('content')
            <div class="row">
              <div class="col-12 col-md-6 col-lg-10">
                <div class="card">
                  <form  enctype="multipart/form-data" method="POST" action="{{ route('transaksi_baru.store') }}">
                  @csrf
                    <div class="card-header">
                      <h4>Create Transaksi</h4>
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
                        <label>Pilih Menu</label>
                          <select name="id_menu" class="form-control">
                            <option value="">--Pilih Menu--</option>
                            @foreach ($menu as $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                          </select>
                      </div>

                      <div class="form-group">
                        <label>Pilih Meja</label>
                          <select name="id_meja" class="form-control">
                            <option value="">--Pilih Meja--</option>
                            @foreach ($meja as $item)
                            <option value="{{$item->id}}">{{$item->no}}</option>
                            @endforeach
                          </select>
                      </div>
                    
                      <div class="form-group">
                       <label>Jumlah</label>
                        <input name="amount" type="text" placeholdrer="Masukan Jumlah" class="form-control" required>
                        <div class="invalid-feedback">
                         Jumlah
                        </div>
                      </div>              
                      
                      <input type="text" name="status" value="1" style="display: none" >
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
@endsection
