@extends('transaksi.master')
@section('content')
<div class="col-12 col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Detail Pesanan</h4>
                <b>Nomor Meja     : {{$transaksi[0]->meja_no}} <b> 
                <b>Waktu Pesanan  : {{$transaksi[0]->created_at}} <b> 
            </div>
            <div class="card-body">
            <table style="width:100%;">
              <tr>
                <td width="25%">Menu</td>
                <td width="5%">:</td>
                <td width="70%">{{$transaksi[0]->menu_nama}}</td>
              </tr>
              <tr>
                <td width="25%">Jumlah</td>
                <td width="5%">:</td>
                <td width="70%">{{$transaksi[0]->amount}}</td>
              </tr>
              <tr>
                <td width="25%">Status</td>
                <td width="5%">:</td>
                <td width="70%">
              
                @if($transaksi[0]->status == 0)
                  <span class="badge badge-primary">Menunggu</span>
                @elseif($transaksi[0]->status == 1)
                  <span class="badge badge-warning">Sedang Di Proses</span>
                @elseif($transaksi[0]->status == 2)
                  <span class="badge badge-success">Sudah Di Bayar</span>
                @elseif($transaksi[0]->status == 3)
                  <span class="badge badge-info">Siap Di Hidangkan</span>
                @elseif($transaksi[0]->status == 4)
                  <span class="badge badge-danger">Pesanan Di Batalkan</span>
                @endif 
                   
                </td>
              </tr>
              <tr>
                <td width="25%">Sub Total</td>
                <td width="5%">:</td>
                <td width="70%">Rp.{{ number_format($transaksi[0]->amount * $transaksi[0]->harga) }}</td>
              </tr>
             </table>
             <br>
             <a class='btn btn-success btn-xs' href="{{URL::to('/')}}/transaksi" >Kembali<i class="glyphicon glyphicon-edit"></i> </a> 
             </div>
        </div>
    </div>
@endsection
@push('page-scripts')
@endpush