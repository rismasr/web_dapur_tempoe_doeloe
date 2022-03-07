@extends('menu.master')
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
                    <h4>Tabel Menu</h4>
                    <a href="{{URL::to('/')}}/addMenu" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Menu</a>
                    <!-- &nbsp;&nbsp;
                    <a href="{{URL::to('/')}}/cetakmenu" class="btn btn-danger"><i class="fa fa-print"></i> Print All</a> -->
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
                            <th>Harga</th>
                            <th>Deskrispi</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th width="200px">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                          $no = 1;
                        ?>
                        @foreach($menu as $p )
                          <tr>
                            <td>{{$no++}}</td>
                            <td>{{$p->nama}}</td>
                            <td>Rp.{{$p->harga}}</td>
                            <td>
                                <?php echo strip_tags("$p->deskripsi");?>
                            </td>
                            <td>{{$p->stok}}</td>
                            <td>
                              <img alt="image" src="{{URL::to('/')}}/assets/menu/{{$p->gambar}}" class="rounded-circle" width="35" data-toggle="tooltip" title="Image">
                            </td>
                            <td style="text-align: center;">
                            <a class='btn btn-info btn-xs' href="{{url('menu/view')}}/{{$p->id}}"><i class="fa fa-eye"></i> </a>
                            <a class='btn btn-info btn-xs' href="{{url('menu/edit')}}/{{$p->id}}" class=""> Edit<i class="glyphicon glyphicon-edit"></i> </a> &nbsp;&nbsp;
                            <a class='btn btn-danger btn-xs' href="#" onclick="functionDelete('{{url('menu/delete')}}/{{$p->id}}')" class=""> Delete<i class="glyphicon glyphicon-edit"></i> </a> 
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