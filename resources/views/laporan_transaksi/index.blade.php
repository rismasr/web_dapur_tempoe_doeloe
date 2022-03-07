@extends('laporan_transaksi.master')
@section('content')
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tabel Penjualan</h4>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#transaksipdf">
                        <i class="fa fa-print"></i> PDF 
                    </button>
                    <button type="button" class="btn btn-success my-3" data-toggle="modal" data-target="#transaksiexcel">
                        <i class="fa fa-print"></i> EXPORT EXCEL 
                    </button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                       @php
                          $no = 1;
                        @endphp
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>No Meja</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Sub Total</th>
                          </tr>
                        </thead>
                        <?php
                          $grand_total = 0;
                        ?>
                        <tbody>
                        @if (!@empty($transaksi))
                    @foreach ($transaksi as $value)
                      @php
                        $status = '';
                      @endphp
                      @if(strtolower($value->status) == 0)
                        @php
                          $status = '<span class="badge badge-primary">Menunggu</span>';
                        @endphp
                      @elseif(strtolower($value->status) == 1)
                        @php
                          $status = '<span class="badge badge-warning">Sedang Di Proses</span>';
                        @endphp
                      @elseif(strtolower($value->status) == 2)
                        @php
                          $status = '<span class="badge badge-success">Sudah Di Bayar</span>';
                        @endphp
                      @elseif(strtolower($value->status) == 3)
                        @php
                          $status = '<span class="badge badge-success">Close Order</span>';
                        @endphp
                      @endif 
                          <tr>
                            <td>{{$no++}}</td>
                            <td>{{$value->meja_no}} pesanan ke {{$value->no_pesanan}}</td>
                            <td>{{$value->menu_nama}}</td>
                            <td>{{ number_format($value->amount) }}</td>
                            <td>{!!$status!!}</td>
                            <td>{{$value->created_at}}</td>
                            <td>Rp.{{ number_format($value->amount * $value->harga) }}</td>
                          </tr>
                          <?php
                            $grand_total += $value->harga * $value->amount;
                          ?>
                          @endforeach
                           @else
                              <tr>
                                <td colspan="8" class="text-center"><i>Tidak Ada Data</i></td>
                              </tr>
                            @endif
                        </tbody>
                        <tr>
                          <th colspan="6">Total</th>
                          <th>Rp.{{number_format($grand_total)}}</th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection
@push('page-scripts')
@endpush
@section('modals')
<!-- Modal transaksipdf -->
<div class="modal fade" id="transaksipdf" tabindex="-1" role="dialog" aria-labelledby="transaksipdfLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="transaksipdfLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{URL::to('/')}}/laporantransaksipdf" method="post" target="_blank">
                @csrf
                @method('post')
                <div class="form-group">
                    <label>Dari Tanggal</label>
                    <input id="dari_tgl" name="dari_tgl" type="date" placeholdrer="masukan masukan tanggal awal" class="form-control" required=""
                      max="{{date('Y-m-d')}}">
                  </div>
                  <div class="form-group">
                      <label>Sampai Tanggal</label>
                      <input id="sampai_tgl" name="sampai_tgl" type="date" placeholdrer="masukan tanggal akhir" class="form-control" required=""
                        max="{{date('Y-m-d')}}">
                  </div>
                  <button type="submit" class="btn btn-primary" >Print PDF</button>
                  {{-- <a href="{{URL::to('/')}}/laporantransaksipdf" class="btn btn-danger"><i class="fa fa-print"></i> PDF </a> --}}
            </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal transaksiexcel -->
<div class="modal fade" id="transaksiexcel" tabindex="-1" role="dialog" aria-labelledby="transaksiexcelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="transaksiexcelLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{URL::to('/')}}/laporanpenjualanexel" method="post" target="_blank">
                @csrf
                @method('post')
                <div class="form-group">
                    <label>Dari Tanggal</label>
                    <input id="dari_tgl" name="dari_tgl" type="date" placeholdrer="masukan masukan tanggal awal" class="form-control" required=""
                      max="{{date('Y-m-d')}}">
                  </div>
                  <div class="form-group">
                      <label>Sampai Tanggal</label>
                      <input id="sampai_tgl" name="sampai_tgl" type="date" placeholdrer="masukan tanggal akhir" class="form-control" required=""
                        max="{{date('Y-m-d')}}">
                  </div>
                  <button type="submit" class="btn btn-primary" >Print EXCEL</button>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection
