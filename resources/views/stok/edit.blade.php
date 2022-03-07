@extends('menu.master')
@section('content')
            <div class="row">
              <div class="col-12 col-md-6 col-lg-10">
                <div class="card">
                  <form id="form" enctype="multipart/form-data" method="POST" action="{{url('updatestok', $menu->id)}}">
                  @csrf
                    <div class="card-header">
                      <h4>Updated Menu</h4>
                    </div>
                    <div class="card-body">
                      {{-- <div class="form-group">
                        <label>Nama</label>
                        <input id="nama" name="nama" type="text" placeholdrer="masukan nama" value="{{$menu->nama}}" class="form-control" required="">
                        <div class="invalid-feedback">
                         nama kosong
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Harga</label>
                        <input id="harga" name="harga" type="number" placeholdrer="masukan harga" value="{{$menu->harga}}" class="form-control" required="">
                        <div class="invalid-feedback">
                         harga kosong
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi" placeholder="Description" required="">{{$menu->deskripsi}}</textarea>
                        <div class="invalid-feedback">
                          Deskripsi kosong
                        </div>
                      </div> --}}
                      <div class="form-group">
                        <label>Stok</label>
                        <input id="stok" name="stok" type="number" placeholdrer="masukan Stok" value="{{$menu->stok}}" class="form-control" required="">
                        <div class="invalid-feedback">
                         stok kosong
                        </div>
                      </div>

                       {{-- <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                <img src="{{URL::to('/')}}/assets/menu/{{$menu->gambar}}" style="width:150px;">
                            </div>
                        </div>

                      <div class="form-group">
                        <label for="exampleInputImage">Ganti Gambar</label>
                        <div class="col-md-6 col-sm-6 ">
                        <input type="file" name="gambar" id="gambar" onchange="fileSelected();"/>
                        </div>
                      </div> --}}
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
@endsection
@push('page-scripts')
