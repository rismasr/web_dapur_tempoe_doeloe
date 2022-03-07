@extends('category.master')
@section('content')
            <div class="row">
              <div class="col-12 col-md-6 col-lg-10">
                <div class="card">
                  <form id="form" enctype="multipart/form-data" method="POST" action="{{url('updatecategory', $category->id)}}">
                  @csrf
                    <div class="card-header">
                      <h4>Updated Category</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label>Nama</label>
                        <input id="nama" name="nama" type="text" placeholdrer="masukan nama kategori" value="{{$category->nama}}" class="form-control" required="">
                        <div class="invalid-feedback">
                         nama kategori kosong
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
@endpush