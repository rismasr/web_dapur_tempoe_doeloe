@extends('profile.master')
@section('content')
<div class="section-body">
  
  <h2 class="section-title">Hi, {{ Auth::user()->name}}</h2>
  <p class="section-lead">
    Change information about yourself on this page.
  </p>
  
  @if(session('success'))
  <div class="alert alert-success alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>×</span>
      </button>
      {{session('success')}}
    </div>
  </div>
  @endif

  @if(session('error'))
  <div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>×</span>
      </button>
      {{session('error')}}
    </div>
  </div>
  @endif


  <div class="row mt-sm-4">

    <div class="col-12 col-md-12 col-lg-5">
      <div class="card profile-widget">
        <form id="form" enctype="multipart/form-data" method="POST" action="{{url('updatepicture', $profile->id)}}">
          @csrf
          <div class="profile-widget-header">
            <img alt="image" src="{{URL::to('/')}}/assets/profile/{{$profile->picture}}" class="rounded-circle profile-widget-picture">
          </div>
          <div class="profile-widget-description">
            <div class="profile-widget-name">{{$profile->name}} <div class="text-muted d-inline font-weight-normal"></div></div>
            <b>{{$profile->email}}</b>.
          </div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 ">
              <input type="file" name="picture" id="picture" onchange="fileSelected();"/>
            </div>
          </div>
          <div class="card-footer text-right">
            <button class="btn btn-primary">Save Picture</button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-12 col-md-12 col-lg-7">
      <div class="card">
        <form method="post" action="{{url('updateprofile', $profile->id)}}" class="needs-validation" novalidate="">
          @csrf
          <div class="card-header">
            <h4>Edit Profile</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="form-group col-md-6 col-12">
                <label>Nama Lengkap</label>
                <input type="text" class="form-control" name="name" value="{{$profile->name}}" required="">
                <div class="invalid-feedback">
                  Please fill in the Name
                </div>
              </div>
              <div class="form-group col-md-6 col-12">
                <label>Email</label>
                <input type="text" class="form-control" name="email" value="{{$profile->email}}" required="">
                <div class="invalid-feedback">
                  Please fill in the Username
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    

    <div class="col-12 col-md-12 col-lg-7">
      <div class="card">
        <form method="post" action="{{url('update-password')}}" class="needs-validation" novalidate="">
          @csrf
          <div class="card-header">
            <h4>Change Password</h4>
          </div>
          <div class="card-body">
            <div class="column">
              <div class="form-group col-md-10 col-12">
                <label>Password Lama</label>
                <input type="password" class="form-control" name="old_password" required="">
                <div class="invalid-feedback">
                  Please fill in the old password
                </div>
              </div>
              <div class="form-group col-md-10 col-12">
                <label>Password Baru</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required="">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-10 col-12">
                <label>Konfirmasi Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required="">
                <div class="invalid-feedback">
                  Please fill in the Confirm Password
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button class="btn btn-primary">Save Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('page-scripts')
@endpush