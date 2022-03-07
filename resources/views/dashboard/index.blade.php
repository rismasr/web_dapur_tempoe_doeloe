@extends('dashboard.master')
@section('content')
<div class="row">
<div class="col-lg-4 col-md-8 col-sm-8">
              <div class="card card-statistic-2">
                <div class="card-stats">
                  <br><br>
                  <div class="card-stats-items">
                    <div class="card-stats-item">
                      <div class="card-stats-item-count">{{$status0}}</div>
                      <div class="card-stats-item-label">Menunggu</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count">{{$status1}}</div>
                      <div class="card-stats-item-label">Sedang Di Proses</div>
                    </div>
                    {{-- <div class="card-stats-item">
                      <div class="card-stats-item-count">{{$status3}}</div>
                      <div class="card-stats-item-label">Siap Di Hidangkan</div>
                    </div> --}}
                    <div class="card-stats-item">
                      <div class="card-stats-item-count">{{$status2}}</div>
                      <div class="card-stats-item-label">Sudah Di Bayar</div>
                    </div>
                    {{-- <div class="card-stats-item">
                      <div class="card-stats-item-count">{{$status4}}</div>
                      <div class="card-stats-item-label">Pesanan Di Batalkan</div>
                    </div> --}}
                  </div>
                </div>
                
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Orders</h4>
                  </div>
                  <div class="card-body">
                    {{$total_orders}}
                  </div>
                </div>
              </div>
            </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-chart">
                  <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Makanan</h4>
                  </div>
                  <div class="card-body">
                    {{$makanan}}
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-chart">
                  <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Minuman</h4>
                  </div>
                  <div class="card-body">
                    {{$minuman}}
                  </div>
                </div>
              </div>
            </div>

          
      </div>

<body>
<div id="content_grafikmenuterlaris"></div>
</body>
@endsection
@push('page-scripts')
@endpush