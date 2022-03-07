@extends('user.master')
@section('content')
<div class="col-12 col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Detail Users</h4>
            </div>
            <div class="card-body">
            <table style="width:100%;">
              <tr>
                <td width="25%">Tanggal Pembuatan Akun</td>
                <td width="5%">:</td>
                <td width="70%">{{$users->created_at}}</td>
              </tr>
              <tr>
                <td width="25%">Nama Lengkap</td>
                <td width="5%">:</td>
                <td width="70%">{{$users->name}}</td>
              </tr>
              <tr>
                <td width="25%">Email</td>
                <td width="5%">:</td>
                <td width="70%">{{$users->email}}</td>
              </tr>
              <tr>
                <td width="25%">Foto Users</td>
                <td width="5%">:</td>
                <td>
                    <img alt="image" src="{{URL::to('/')}}/assets/profile/{{$users->picture}}" class="rounded-circle" width="200" height="200" data-toggle="tooltip" title="Foto Pelanggan">
                </td>    
              </tr>
             </table>
             <a class='btn btn-success btn-xs' href="{{URL::to('/')}}/users" >Kembali<i class="glyphicon glyphicon-edit"></i> </a> 
             </div>
        </div>
    </div>
@endsection
@push('page-scripts')
@endpush