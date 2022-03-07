@extends('menu.master')
@section('content')
<div class="col-12 col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Detail Menu</h4>
            </div>
            <div class="card-body">
            <table style="width:100%;">
              <tr>
                <td width="25%">Tanggal Pembuatan Menu</td>
                <td width="5%">:</td>
                <td width="70%">{{$menu->created_at}}</td>
              </tr>
              <tr>
                <td width="25%">Nama Menu</td>
                <td width="5%">:</td>
                <td width="70%">{{$menu->nama}}</td>
              </tr>
              <tr>
                <td width="25%">Harga</td>
                <td width="5%">:</td>
                <td width="70%">{{$menu->harga}}</td>
              </tr>
              <tr>
                <td width="25%">Deskripsi</td>
                <td width="5%">:</td>
                <td width="70%"><?php echo strip_tags("$menu->deskripsi");?></td>
              </tr>
              <tr>
                <td width="25%">Stok</td>
                <td width="5%">:</td>
                <td width="70%">{{$menu->stok}}</td>
              </tr>
              <tr>
                <td width="25%">Gambar</td>
                <td width="5%">:</td>
                <td>
                    <img alt="image" src="{{URL::to('/')}}/assets/menu/{{$menu->gambar}}" class="rounded-circle" width="200" height="200" data-toggle="tooltip" title="Foto Pelanggan">
                </td>    
              </tr>
             </table>
             <a class='btn btn-success btn-xs' href="{{URL::to('/')}}/menu" >Kembali<i class="glyphicon glyphicon-edit"></i> </a> 
             </div>
        </div>
    </div>
@endsection
@push('page-scripts')
@endpush