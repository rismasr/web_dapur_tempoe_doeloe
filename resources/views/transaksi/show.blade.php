@extends('transaksi.master')
@section('content')
        <div class="row">
              <div class="col-12 col-md-6 col-lg-10">
              <div class="card">
            <div class="card-header">
                <h4>Detail Pesanan No Meja : {{$transaksi[0]->meja_no}}</h4>
            </div>
            <div class="card-body">
            <table style="width:100%;">
              <tr>
                <td width="25%">Tanggal</td>
                <td width="5%">:</td>
                <td width="70%">{{$transaksi[0]->created_at}}</td>
              </tr>
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
              <br>
             </table>
             <br>
             </div>
          </div>

                <div class="card">
                <form  id="formD" name="formD" enctype="multipart/form-data" method="POST" action="{{URL::to('/')}}/pembayaran1/save/{{$transaksi[0]->id_meja}}/{{$transaksi[0]->id}}">
                  <!-- <form  id="formD" name="formD"enctype="multipart/form-data" method="POST" action="{{ route('transaksi.update',$transaksi[0]->id) }}"> -->
                  @csrf
                    <div class="card-header">
                      <h4>Pembayaran</h4>
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

                    @php
                    $totalBayar     = $transaksi[0]->amount * $transaksi[0]->harga;
                    @endphp
                    
                    <div class="form-group">
                        <label>Total (Rp)</label>
                        <input id="grand_total" name="grand_total" value="{{$totalBayar}}" type="text" 
                        onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" placeholdrer="masukan uang" class="form-control">
                        <div class="invalid-feedback">
                         Total
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Bayar</label>
                        <input id="uang-masuk" name="uangmasuk"  onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" placeholdrer="masukan uang" class="form-control" >
                        <div class="invalid-feedback">
                         Total
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Kembalian</label>
                        <input id="uangkembalian" name="uangkembalian" value=""  class="form-control">
                        <div class="invalid-feedback">
                         Total
                        </div>
                      </div>

                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                  <script type="text/javascript" language="Javascript">
                    totalUang = document.formD.grand_total.value;
                    jumlahUang = document.formD.uangmasuk.value;
                    function OnChange(value){
                      totalUang = document.formD.grand_total.value;
                      jumlahUang = document.formD.uangmasuk.value;
                      kembalian = jumlahUang - totalUang;
                      document.formD.uangkembalian.value = kembalian;
                    }
                  </script>
                </div>
              </div>
            </div>
@endsection
