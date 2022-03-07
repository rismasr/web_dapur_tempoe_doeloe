@extends('category.master')
@section('content')
            <div class="row">
              <div class="col-12 col-md-6 col-lg-10">
                <div class="card">
                  <form id="form" enctype="multipart/form-data" method="POST" action="{{URL::to('/')}}/category/save">
                  @csrf
                    <div class="card-header">
                      <h4>Created Category</h4>
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
                        <label>Nama</label>
                        <input id="nama" name="nama" type="text" placeholdrer="masukan nama kategori" class="form-control" required="">
                        <div class="invalid-feedback">
                         Nama Kategori kosong
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