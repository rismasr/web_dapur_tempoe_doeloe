<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Data Penjualan</title>
	<link rel="shorcut icon" href="" types="images/x-icon">
	<style type="text/css">
		table {
			border-collapse: collapse;
		}
		table thead tr th,
		table tbody tr td {
     font-size: 12px;
     padding: 5px;
   }
 </style>
</head>
<body>
	<?php 
  date_default_timezone_set('Asia/Jakarta');
  $tahun = date('Y');
  $no = 1;
  ?>
  <h4 style="text-align: center;">DAPOER TEMPOE DOELOE</h4>
  <h4 style="text-align: center;">LAPORAN DATA TRANSAKSI</h4>
  <table border="2" style="width: 100%;">
    <thead>
      <tr>
        <th style="background-color:#444;color:#fff;"  class="text-center">
          #
        </th>
        <th style="background-color:#444;color:#fff;">No Meja</th>
        <th style="background-color:#444;color:#fff;" >Menu</th>
        <th style="background-color:#444;color:#fff;" >Jumlah</th>
        <th style="background-color:#444;color:#fff;" >Status</th>
        <th style="background-color:#444;color:#fff;" >Tanggal</th>
        <th style="background-color:#444;color:#fff;" width="200px">Sub Total</th>
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
      $status = '<span class="badge badge-success">Siap Di Hidangkan</span>';
      @endphp
      @elseif(strtolower($value->status) == 4)
      @php
      $status = '<span class="badge badge-success">Pesanan Di Batalkan</span>';
      @endphp
      @endif 
      <tr>
        <td>{{$no++}}</td>
        <td>{{$value->meja_no}}</td>
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
</body>
