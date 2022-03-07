@extends('terlaris.master')
@section('content')
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tabel Terlaris</h4>
                    {{-- <a href="{{URL::to('/')}}/users/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Users</a> --}}
                    {{-- &nbsp;&nbsp; --}}
                    {{-- <a href="{{URL::to('/')}}/cetakmenu" class="btn btn-danger"><i class="fa fa-print"></i> Print All</a> --}}
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
                            <th>Terjual</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                          $no = 1;
                        ?>
                        @foreach($laris as $p )
                          <tr>
                            <td>{{$no++}}</td>
                            <td>{{$p->nama}}</td>
                            <td>{{ $p->menu_terjual }}</td>
                            <td style="text-align: center;">
                            {{-- <a class='btn btn-info btn-xs' href="{{ route('users.edit',$p->id) }}" class=""> Edit<i class="glyphicon glyphicon-edit"></i> </a> &nbsp;&nbsp;
                            <a class='btn btn-danger btn-xs' href="#" onclick="functionDelete('{{url('users/delete')}}/{{$p->id}}')" class=""> Delete<i class="glyphicon glyphicon-edit"></i> </a>  --}}
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
