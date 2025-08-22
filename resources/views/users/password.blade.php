@extends('layouts.app')
@section('css')
@section('content')
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

      <div class="row page-titles mx-0">
            <div class="col p-md-0">
                  <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('users')}}">Users</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Password</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="pl-2 mb-0 ml-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <div class="card mb-4">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Update Password</h4>
                              </div>
                              <form action="{{ route('admin.password.update') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                          <div class="row">
                                                <input type="hidden" name="id" value="{{isset($user)?$user->id:''}}" />

                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="current_password">Current Password<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="password" name="current_password"
                                                            maxlength="16" placeholder="Enter password" value="{{ old('current_password') }}" required />
                                                      @error('password')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                          </div>
                                            <div class="row">

                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="password">New Password<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="password" name="password"
                                                            maxlength="16" placeholder="Enter password" required />
                                                      @error('password')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="password_confirmation">Confirm New Password<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="password" name="password_confirmation" value=""
                                                            maxlength="16" placeholder="Renter new Password" required />
                                                      @error('password_confirmation')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                          </div>

                                    </div>
                                    <div class="card-footer">

                                          <div class="row">
                                                <div class="col-md-12">
                                                      <a href="{{ url('users') }}" class="btn btn-danger">Cancel</a>
                                                      <button class="btn btn-primary">Update Password</button>
                                                </div>
                                          </div>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
      <!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->
@endsection
