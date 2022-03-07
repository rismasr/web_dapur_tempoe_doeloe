@extends('meja.master')
@section('content')
            <div class="row">
              <div class="col-12 col-md-6 col-lg-10">
                <div class="card">
                  <form id="form" enctype="multipart/form-data" method="POST" action="{{url('updatemeja', $meja->id)}}">
                  @csrf
                    <div class="card-header">
                      <h4>Updated Meja</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label>No Meja</label>
                        <input id="no" name="no" type="number" placeholdrer="masukan no meja" value="{{$meja->no}}" class="form-control" required="">
                        <div class="invalid-feedback">
                         no meja kosong
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