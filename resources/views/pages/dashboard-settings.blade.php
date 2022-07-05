@extends('layouts.dashboard')

@section('title')
    Store Settings
@endsection

@section('content')
<!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
  <div class="container-fluid">
      <div class="dashboard-heading">
          <h2 class="dashboard-title">My Profile</h2>
          <p class="dashboard-subtitle">Update your current profile</p>
      </div>
      <div class="row">
          <div class="col-12">
              <div class="card card-list p-3">
                  <div class="card-body">
                      <form id="locations" action="{{ route('dashboard-settings-redirect','dashboard-settings-account') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          {{-- ini blm bisa nyimpen? provice idnya ga kesimpen --}}
                          <div class="form-row">
                              <div class="form-group col-12 col-md-6">
                                  <label for="name">Nama</label>
                                  <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                              </div>
                              <div class="form-group col-12 col-md-6">
                                  <label for="email">Email</label>
                                  <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-12 col-md-6">
                                  <label for="address_one">Address 1</label>
                                  <input type="text" class="form-control" id="address_one" name="address_one" value="{{ $user->address_one }}">
                              </div>
                              <div class="form-group col-12 col-md-6">
                                  <label for="address_two">Address 2</label>
                                  <input type="text" class="form-control" id="address_two" name="address_two" value="{{ $user->address_two }}">
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group pl-3 pl-lg-4 col-md-6">
                                  <label for="phone_number">Mobile</label>
                                  <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $user->phone_number }}">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col text-right">
                                  <button type="submit" class="btn btn-success px-5">
                                  Save Now
                              </button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection