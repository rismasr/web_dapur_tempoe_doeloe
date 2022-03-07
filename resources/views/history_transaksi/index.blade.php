@extends('history_transaksi.master')
@section('content')
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tabel History Transaksi</h4>
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
                            <th>Action</th>
                          </tr>
                        </thead>
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
                            <td>{{$value->meja_no}}</td>
                            <td>{{$value->menu_nama}}</td>
                            <td>{{ number_format($value->amount) }}</td>
                            <td>{!!$status!!}</td>
                            <td style="text-align: center;">
                      @if(strtolower($value->status) == 0)
                        <a href="javascript:void(0)" onclick="approveData({{ $value->id }})" class="btn btn-primary p-0" data-original-title="" title="">
                          Approve
                        </a>
                        <a href="javascript:void(0)" onclick="tolakData({{ $value->id }})" class="btn btn-warning p-0" data-original-title="" title="">
                          Reject
                        </a>
                      @endif 
                        <a href="javascript:void(0)" onclick="hapusData({{ $value->id }})" class="btn btn-danger p-0" data-original-title="" title="">
                          Delete
                        </a>
                        
                        <form id="delete-{{ $value->id }}" action="{{ route('historytransaksi.deleted', $value->id) }}" method="post" style="display:none;">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="id" value="{{ $value->id }}">
                          <input type="submit" value="OK">
                        </form>
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
@push('page-scripts')
 <script>
    function hapusData(id){
      swal({
        title: 'Apakah anda yakin akan menghapus data ini?',
        text: "Jika data di hapus, maka History Transaksi akan terhapus",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Tidak, Kembali!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
        $('#delete-'+id).submit();
      }, function (dismiss) {
        if (dismiss === 'cancel') {
          swal("Gagal", "History Transaksi tidak jadi dihapus", "error")
        }
      })
    }

  </script>
@endpush
