<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{config('app.name')}}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <!-- DataTables -->
  
  <link rel="stylesheet" href="http://streetfoodicons.com/stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="http://streetfoodicons.com/stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">

  <!-- <link rel="stylesheet" href="{{URL::to('/')}}/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->

  <!-- SweetAlert 2-->
  <link href="{{URL::to('/')}}/assets/sweetalert/sweetalert2.min.css" rel="stylesheet" type="text/css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/style.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/components.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  @stack('page-styles')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      @include('transaksi_baru.header')
      @include('transaksi_baru.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
        <div class="section-header">
            <h1>Pesanan</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item">Dashboard</div>
              <div class="breadcrumb-item active"><a href="#">Pesanan</a></div>
            </div>
          </div>

          @yield('content')
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2021 <div class="bullet"></div> Created By <a href="">Dapoer Tempo Doeloe</a>
        </div>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>
    </div>
  </div>

  @stack('before-scripts')
  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <!-- DataTables -->
  <script src="http://streetfoodicons.com/stisla/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="http://streetfoodicons.com/stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="http://streetfoodicons.com/stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>

  <!-- Template JS File -->
  <script src="{{URL::to('/')}}/assets/js/scripts.js"></script>
  <script src="{{URL::to('/')}}/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="{{URL::to('/')}}/assets/js/page/modules-datatables.js"></script>

   <!-- SweetAlert 2-->
   <script src="{{URL::to('/')}}/assets/sweetalert/sweetalert2.min.js"></script>
   <script src="{{URL::to('/')}}/assets/sweetalert/sweetalert2.common.min.js"></script>

  
  @stack('page-scripts')
</body>
</html>
