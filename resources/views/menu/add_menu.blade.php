@extends('menu.master')
@section('content')
            <div class="row">
              <div class="col-12 col-md-6 col-lg-10">
                <div class="card">
                  <form id="form" enctype="multipart/form-data" method="POST" action="{{URL::to('/')}}/menu/save">
                  @csrf
                    <div class="card-header">
                      <h4>Create Menu</h4>
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
                        <label>Pilih Kategori</label>
                          <select name="id_kategori" class="form-control">
                            <option value="">--Pilih Menu--</option>
                            @foreach ($category as $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                          </select>
                      </div>
                      
                      <div class="form-group">
                        <label>Nama </label>
                        <input id="nama" name="nama" type="text" placeholdrer="masukan nama" class="form-control" required="">
                        <div class="invalid-feedback">
                         nama kosong
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label>Harga</label>
                        <input id="harga" name="harga" type="number" placeholdrer="masukan harga" class="form-control" required="">
                        <div class="invalid-feedback">
                         harga kosong
                        </div>
                      </div>
                      <div class="form-group mb-0">
                        <label>Description</label>
                        <textarea id="deskripsi" class="form-control" name="deskripsi" rows="10" cols="50"></textarea>
                        <div class="invalid-feedback">
                          Deskripsi kosong
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Stok</label>
                        <input id="stok" name="stok" type="number" placeholdrer="masukan Stok" class="form-control" required="">
                        <div class="invalid-feedback">
                         stok kosong
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputImage">Gambar</label>
                        <div class="col-md-6 col-sm-6 ">
                        <input type="file" name="gambar" id="gambar" onchange="fileSelected();"/>
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
@push('page-scripts')
<script src="{{URL::to('/')}}/assets/ckeditor/ckeditor.js"></script>
<script>
   var konten = document.getElementById("deskripsi");
     CKEDITOR.replace(konten,{
     language:'en-gb'
   });
   CKEDITOR.config.allowedContent = true;
</script>
@endpush