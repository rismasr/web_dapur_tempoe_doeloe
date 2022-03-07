@extends('transaksi.master')
@section('content')
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tabel Pesanan</h4>
                    <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create</a>
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
                            
                            {{-- <input  type="submit" name="print" class="btn btn-danger" value="Cetak Struk" > --}}
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
                    @php
                      $idx = 1;
                      $first = null;
                      $last = null;    
                      $key = []; 
                      $newIdx = 1;
                    @endphp
                    @foreach ($transaksi as $value)
                      @php
                        $status = '';
                        if($idx % 2 == 0){
                          $last = [$value->no_pesanan, $value->status];
                        } else {
                          $first = [$value->no_pesanan, $value->status];
                        }

                        // if($last != null && $first != null){
                        //   if($last[0] == $first[0] && $last[1] == 2 && $first[1] == 2){
                        //     $key[] = $idx-1;
                        //     $newIdx--;
                        //     $last = $first = null;
                        //     continue;
                        //   }
                        // }
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
                          <tr id="{{$idx}}">
                          {{-- <td>{{$no++}} {{$idx}}</td> --}}
                          <td>{{$newIdx++}}</td>
                          <td>{{$value->meja_no}} pesanan ke {{$value->no_pesanan}}</td>
                            <td>{{$value->menu_nama}}</td>
                            <td>{{ number_format($value->amount) }}</td>
                            <td>{!!$status!!}</td>
                            <td>Rp.{{ number_format($value->amount * $value->harga) }}</td>
                            <td>{{$value->created_at}}</td>
                            <td style="text-align: center;">
                            <a class='btn btn-primary' href="{{url('transaksi/view')}}/{{$value->id}}"><i class="fa fa-eye"></i> </a>
                      @if(strtolower($value->status) == 0)
                        <a href="javascript:void(0)" onclick="approveData({{ $value->id }})" class="btn btn-warning" data-original-title="" title=""><i class="fa fa-check"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="tolakData({{ $value->id }})" class="btn btn-danger" data-original-title="" title=""><i class="fa fa-close"></i>
                        </a>
                      @endif
                      @if(strtolower($value->status) == 1)
                      <a href="javascript:void(0)" onclick="selesaiData({{ $value->id }})" class="btn btn-info" data-original-title="" title=""><i class="fa fa-check-square-o"></i>
                      </a>
                      @endif

                        <form id="approve-{{ $value->id }}" action="{{ route('transaksi.approve', $value->id) }}" method="post" style="display:none;">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="id" value="{{ $value->id }}">
                          <input type="hidden" name="status" value="1">
                          <input type="submit" value="OK">
                        </form>

                        <form id="tolak-{{ $value->id }}" action="{{ route('transaksi.tolak', $value->id) }}" method="post" style="display:none;">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="id" value="{{ $value->id }}">
                          <input type="hidden" name="status" value="4">
                          <input type="submit" value="OK">
                        </form>
                        <form id="selesai-{{ $value->id }}" action="{{ route('transaksi.selesai', $value->id) }}" method="post" style="display:none;">
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
                            $idx++;
                          ?>
                          @endforeach
                           @else
                              <tr>
                                <td colspan="8" class="text-center"><i>Tidak Ada Data</i></td>
                              </tr>
                            @endif
                        </tbody>
                        <tr>
                          <th colspan="6">Total Bayar</th>
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
          swal("Gagal", "Transaksi tidak jadi disetujui", "error")
        }
      })
    }
    
  let tabledt = $("#table-datatables").dataTable({
    "columnDefs": [
      { "sortable": false, "targets": [2,3] }
    ]
  });

  $('#statusDropdown').on('change',function(){
        var selectedValue = $(this).val();
        console.log(selectedValue);
        tabledt.fnFilter("^"+selectedValue+"$", 4, true); //Exact value, column, reg
    });

    function removeTab(rowId){
      $('#' + rowId).remove();
    }

    let arrKey = JSON.parse('{{json_encode($key)}}');
    for(let i = 0; i < arrKey.length; i++){
      removeTab(arrKey[i]);
    }
    console.log(arrKey.length);
  </script>
@endpush
