@extends('user.master')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible show fade">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>×</span>
    </button>
    {{session('success')}}
  </div>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible show fade">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>×</span>
    </button>
    {{session('error')}}
  </div>
</div>
@endif
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tabel Users</h4>
                    <a href="{{URL::to('/')}}/users/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Users</a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="200px">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                          $no = 1;
                        ?>
                        @foreach($account as $p )
                          <tr>
                            <td>{{$no++}}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->email}}</td>
                            <td>{{$p->nama_role}}</td>
                            <td style="text-align: center;">
                            <a class='btn btn-info btn-xs' href="{{url('users/view')}}/{{$p->id}}"><i class="fa fa-eye"></i> </a>
                            <a class='btn btn-info btn-xs' href="{{ route('users.edit',$p->id) }}" class=""> Edit<i class="glyphicon glyphicon-edit"></i> </a> &nbsp;&nbsp;
                            <a class='btn btn-danger btn-xs' href="#" onclick="functionDelete('{{url('users/delete')}}/{{$p->id}}')" class=""> Delete<i class="glyphicon glyphicon-edit"></i> </a> 
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection
@push('page-scripts')
@endpush