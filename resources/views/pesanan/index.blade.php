@extends('transaksi.master')
@section('content')
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tabel Pesanan</h4>
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
                        </div>
                    </div>
                </form>

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
                            <th>Sub Total</th>
                            <th>Tanggal</th>
                            <th>Action</th>
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
                          $status = '<span class="badge badge-info">Siap Di Hidangkan</span>';
                        @endphp
                      @elseif(strtolower($value->status) == 4)
                        @php
                          $status = '<span class="badge badge-danger">Pesanan Di Batalkan</span>';
                        @endphp
                      @endif 
                          <tr>
                            <td>{{$no++}}</td>
                            <td>{{$value->meja_no}}</td>
                            <td>{{$value->menu_nama}}</td>
                            <td>{{ number_format($value->amount) }}</td>
                            <td>{!!$status!!}</td>
                            <td>Rp.{{ number_format($value->amount * $value->harga) }}</td>
                            <td>{{$value->created_at}}</td>
                            <td style="text-align: center;">
                            <a class='btn btn-primary' href="{{url('transaksi/view')}}/{{$value->id}}"><i class="fa fa-eye"></i> </a>
                      @if(strtolower($value->status) == 0)
                        <a href="javascript:void(0)" onclick="approveData({{ $value->id }})" class="btn btn-success" data-original-title="" title=""><i class="fa fa-check"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="tolakData({{ $value->id }})" class="btn btn-danger" data-original-title="" title=""><i class="fa fa-close"></i>
                        </a>
                      @endif

                      @if(strtolower($value->status) == 1)
                      <a href="javascript:void(0)" onclick="selesaiData({{ $value->id }})" class="btn btn-info" data-original-title="" title=""><i class="fa fa-check-square-o"></i>
                      </a>
                    @endif
                        
                        <form id="approve-{{ $value->id }}" action="{{ route('pesanan.approve', $value->id) }}" method="post" style="display:none;">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="id" value="{{ $value->id }}">
                          <input type="hidden" name="status" value="1">
                          <input type="submit" value="OK">
                        </form>

                        <form id="tolak-{{ $value->id }}" action="{{ route('pesanan.tolak', $value->id) }}" method="post" style="display:none;">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="id" value="{{ $value->id }}">
                          <input type="hidden" name="status" value="4">
                          <input type="submit" value="OK">
                        </form>
                        
                        <form id="selesai-{{ $value->id }}" action="{{ route('pesanan.selesai', $value->id) }}" method="post" style="display:none;">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="id" value="{{ $value->id }}">
                          <input type="hidden" name="status" value="3">
                          <input type="submit" value="OK">
                        </form>
                            </td>
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
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection
@push('page-scripts')
 <script>
    
    function approveData(id){
      swal({
        title: 'Apakah anda yakin akan menyetujui data ini?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Setuju',
        cancelButtonText: 'Tidak, Kembali!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
        $('#approve-'+id).submit();
      }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
          swal("Gagal", "Transaksi tidak jadi disetujui", "error")
        }
      })
    }

    function selesaiData(id){
      swal({
        title: 'Apakah anda yakin akan menyetujui data ini?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Setuju',
        cancelButtonText: 'Tidak, Kembali!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
        $('#selesai-'+id).submit();
      }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
          swal("Gagal", "Transaksi tidak jadi disetujui", "error")
        }
      })
    }

    function bayar(id){
      swal({
        title: 'Apakah anda yakin akan menyetujui data ini?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Setuju',
        cancelButtonText: 'Tidak, Kembali!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
        $('#bayar-'+id).submit();
      }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
          swal("Gagal", "Transaksi tidak jadi disetujui", "error")
        }
      })
    }

    function tolakData(id){
      swal({
        title: 'Apakah anda yakin akan menolak data ini?',
        // text: "Jika data di hapus, maka Transaksi akan terhapus",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Setuju',
        cancelButtonText: 'Tidak, Kembali!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
        $('#tolak-'+id).submit();
      }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
          swal("Gagal", "Transaksi tidak jadi ditolak", "error")
        }
      })
    }
  </script>
@endpush
