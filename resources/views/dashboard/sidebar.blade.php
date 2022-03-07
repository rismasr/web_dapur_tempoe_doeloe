<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">Dapoer Tempo Doeloe</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">DTD</a>
    </div>
    <ul class="sidebar-menu">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img alt="image" src="{{URL::to('/')}}/assets/profile/{{ Auth::user()->picture}}" class="rounded-circle mr-1" width="70px" height="70px">
            <!--<img src="{{ asset('assets/images/faces-clipart/pic-1.jpg') }}" alt="profile" width="40px" height="40px">-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{ ucfirst(Auth::user()->name) }}</span>
            <span class="text-primary text-small">{{Auth::user()->role[0]->name}}</span>
          </div>
        </a>
      </li>
    </ul>
    <br>
    <ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
        <li class="active"><a class="nav-link" href="{{URL::to('/')}}/"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
        
        <li class="menu-header">Menu Utama</li>
       
        <li ><a class="nav-link" href="{{URL::to('/')}}/profile"><i class="fa fa-user"></i> <span>Profile</span></a></li>
        @can('isAdmin')
        <li ><a class="nav-link" href="{{URL::to('/')}}/role"><i class="far fa-user"></i> <span>Kelola User Role</span></a></li>
        <li ><a class="nav-link" href="{{URL::to('/')}}/users"><i class="fas fa-users"></i> <span>Kelola Users</span></a></li>
        <li><a class="nav-link" href="{{URL::to('/')}}/meja"><i class="fas fa-th-large"></i> <span>Meja</span></a></li>
        <li ><a class="nav-link" href="{{URL::to('/')}}/category"><i class="fas fa-table"></i> <span>Kategori</span></a></li>
        <li><a class="nav-link" href="{{URL::to('/')}}/menu"><i class="far fa-file-alt"></i> <span>Menu</span></a></li>
        <li ><a class="nav-link" href="{{URL::to('/')}}/transaksi"><i class="far fa-file-alt"></i> <span>Pesanan</span></a></li>
        <li ><a class="nav-link" href="{{URL::to('/')}}/laporanTransaksi"><i class="fa fa-file"></i> <span>Laporan Penjualan</span></a></li>
        <li><a class="nav-link" href="{{URL::to('/')}}/terlaris"><i class="fas fa-table"></i> <span>Menu Terlaris</span></a></li>
        @endcan
        @can('isDapur')
        <li><a class="nav-link" href="{{URL::to('/')}}/stok"><i class="fas fa-table"></i> <span>Stok Menu</span></a></li>
        <li ><a class="nav-link" href="{{URL::to('/')}}/pesanan"><i class="far fa-file-alt"></i> <span>Pesanan</span></a></li>
        @endcan
        @can('isKasir')
        <li ><a class="nav-link" href="{{URL::to('/')}}/meja"><i class="fas fa-th-large"></i> <span>Meja</span></a></li>
        <li ><a class="nav-link" href="{{URL::to('/')}}/transaksi"><i class="far fa-file-alt"></i> <span>Pesanan</span></a></li>
        <li ><a class="nav-link" href="{{URL::to('/')}}/laporanTransaksi"><i class="fa fa-file"></i> <span>Laporan Penjualan</span></a></li>
        @endcan
  </aside>
</div>