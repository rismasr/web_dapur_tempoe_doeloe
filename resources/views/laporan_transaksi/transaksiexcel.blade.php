<table>
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>No Meja</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
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
                            $value->harga * $value->amount;
                          ?>
                          @endforeach
                           @else
                              <tr>
                                <td colspan="8" class="text-center"><i>Tidak Ada Data</i></td>
                              </tr>
                            @endif
                            
    </tbody>
</table>