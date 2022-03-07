@extends('transaksi.master')
@section('content')
            <div class="row">
              <div class="col-12 col-md-6 col-lg-10">
          <div class="card">
          
            <div class="card-header">
                <h4>Detail Pesanan</h4>
            </div>
                  
            <div class="card-body">
            @foreach ($transaksi as $value)
            <table style="width:100%;">
              <tr>
                <td width="15%">Nomor Meja</td>
                <td width="5%">:</td>
                <td width="80%">{{$value->meja_no}} pesanan ke {{$value->no_pesanan}}</td>
              </tr>
              <tr>
                <td width="15%">Waktu Pesanan</td>
                <td width="5%">:</td>
                <td width="80%">{{$value->created_at}}</td>
              </tr>
              <tr>
                  <td width="25%">Menu</td>
                  <td width="5%">:</td>
                  <td width="70%">{{$value->menu_nama}}</td>
                </tr>
                <tr>
                  <td width="25%">Jumlah</td>
                  <td width="5%">:</td>
                  <td width="70%">{{$value->amount}}</td>
                </tr>
              <tr>
                <td width="25%">Sub Total</td>
                <td width="5%">:</td>
                <td width="70%">Rp.{{ number_format($value->amount * $value->harga) }}</td>
              </tr>
              <br>
             </table>
             @endforeach
             <br>
             </div>
          </div>

                    <?php
                      $id_meja = 0;
                      $no_pesanan = 0;
                    ?>
                    @foreach ($transaksi as $value)
                    @php
                    $id_meja = $value->id_meja;
                    $no_pesanan = $value->no_pesanan;
                    @endphp
                    @endforeach
          
                <div class="card">
                  <form  id="formD" name="formD" enctype="multipart/form-data" method="POST" action="{{URL::to('/')}}/pembayaran/save/{{$id_meja}}" target="_blank">
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

                    <?php
                      $grand_total = 0;
                    ?>

                    @foreach ($transaksi as $value)
                    @php
                    $grand_total += $value->harga * $value->amount;
                    @endphp
                    @endforeach
                          
                      <div class="form-group">
                      <label>Grand Total (Rp)</label>
                        <input name="grand_total" value="{{$grand_total}}" type="text" placeholdrer="Masukan Jumlah" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)"
                        class="form-control" >
                        <div class="invalid-feedback">
                         Grand Total Bayar
                        </div>
                      </div>          
                      
                      <input type="hidden" name="no_pesanan" value="{{$no_pesanan}}">
                 
                     <div class="form-group">
                        <label>Bayar</label>
                        <input id="uang-masuk" name="uangmasuk"  type="number" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)" placeholdrer="masukan uang" class="form-control" >
                        <div class="invalid-feedback">
                         Bayar
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Kembalian</label>
                        <input id="uangkembalian" name="uangkembalian"  class="form-control">
                        <div class="invalid-feedback">
                         Kembalian
                        </div>
                      </div>

                    <div class="card-footer text-right">
                      <button class="btn btn-primary" id="btn-submit">Submit</button>
                    </div>
                  </form>
                     <script type="text/javascript" language="Javascript">
                    totalUang = document.formD.grand_total.value;
                    jumlahUang = document.formD.uangmasuk.value;
                    function OnChange(value){
                      totalUang = document.formD.grand_total.value;
                      jumlahUang = document.formD.uangmasuk.value;
                      uangkembalian = jumlahUang - totalUang;
                      document.formD.uangkembalian.value = uangkembalian;
                    }
                  </script>
                </div>
              </div>
            </div>
@endsection

@push('page-scripts')
  <script>
  $(() => {
    $('#btn-submit').click((e) => {
      setTimeout(() => {
        window.location.href = "{{route('transaksi.index')}}";
      }, 3000);
    })
  })
  </script>
@endpush