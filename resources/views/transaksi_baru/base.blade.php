@extends('transaksi_baru.master')
@section('content')
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tabel Pesanan</h4>
                    <a href="{{ route('transaksi_baru.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create</a>
                  </div>

              <div class="card-body">
                <form method="POST" action="{{ url('cari') }}">
                @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="cari" class="form-control" placeholder="Search Meja">
                        </div>
                        <div class="col-md-6">
                            <input type="submit" name="search" class="btn btn-primary" value="Search">
                            
                            <input  type="submit" name="print" class="btn btn-danger" value="Cetak Struk" >
                            <input  type="submit" name="bayar" class="btn btn-success" value="Bayar" >
                            
                        </div>
                    </div>
                </form>
              </div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                        <label>Pilih Status Pesanan</label>
                        <select class="form-control selectric" id="statusDropdown">
                          <option>Menunggu</option>
                          <option>Sedang Di Proses</option>
                          <option>Siap Di Hidangkan</option>
                          <option>Sudah Di Bayar</option>
                          <option>Pesanan Di Batalkan</option>
                        </select>
                      </div>
                  </div>
                </div>
                                 
                  <div class="card-body">
                    <div class="table-responsive">
                       @php
                          $no = 1;
                        @endphp
                      <table class="table table-striped" id="table-datatables">
                        <thead>
                          <tr>
                            <th>No Meja</th>
                            <th>Pesanan On Going</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <?php
                          $grand_total = 0;
                        ?>
                        <tbody>
                        @if (!@empty($meja))
                        @php
                            $no =1;
                        @endphp
                    @foreach ($meja as $value)
                          <tr>
                          <td>{{$no++}}</td>
                          <td>{{$value->no}}</td>
                          <td>{{$value->no}}</td>
                            <td style="text-align: center;">
                            <a class='btn btn-primary' href="{{url('transaksi/view')}}/{{$value->id}}"><i class="fa fa-eye"></i> </a>
                            </td>
                          </tr>
                          @endforeach
                           @else
                              <tr>
                                <td colspan="8" class="text-center"><i>Tidak Ada Data</i></td>
                              </tr>
                            @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection
