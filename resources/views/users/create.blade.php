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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        @if (session()->has('error'))
                        <div class="alert alert-danger">
                              {{ session()->get('error') }}
                        </div>
                        @endif
                        <div class="card mb-4">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">{{isset($user)?'Update':'Add New'}} User</h4>
                              </div>
                              <form action="{{ url('users/store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                          <div class="row">
                                                <input type="hidden" name="id" value="{{isset($user)?$user->id:''}}" />
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="name">Name<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="text" name="name" value="{{isset($user)?$user->name:old('name')}}"
                                                            maxlength="50" placeholder="Enter name" required />
                                                      @error('name')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="email">Email<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="email" name="email" value="{{isset($user)?$user->email:old('email')}}"
                                                            maxlength="50" placeholder="Enter email" required />
                                                      @error('email')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="phone">Phone<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="text" name="phone" value="{{isset($user)?$user->phone:old('phone')}}"
                                                            maxlength="50" placeholder="Enter phone" required />
                                                      @error('phone')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="role">Role<span class="text-danger">*</span> </label>
                                                      <select class="form-control select2" name="role" id="role" required style="width: 100%;">
                                                            @foreach($roles as $role)
                                                            <option value="{{ $role->name }}" {{ (isset($user) && $user->hasRole($role->name)) ? 'selected' : '' }}>{{ $role->name??'' }}</option>
                                                            @endforeach
                                                      </select>
                                                      @error('role')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="password">Password<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="password" name="password"
                                                            maxlength="16" placeholder="Enter password" required />
                                                      @error('password')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="name">Confirm Password<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="password" name="password_confirmation" value=""
                                                            maxlength="16" placeholder="Renter Password" required />
                                                      @error('password_confirmation')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="address">Address </label>
                                                      <input class="form-control" type="text" name="address" value="{{isset($user)?$user->address:old('address')}}"
                                                            maxlength="255" placeholder="Enter address" />
                                                </div>

                                          </div>

                                    </div>
                                    <div class="card-footer">

                                          <div class="row">
                                                <div class="col-md-12">
                                                      <a href="{{ url('users') }}" class="btn btn-danger">Cancel</a>
                                                      <button class="btn btn-primary">{{isset($user)?'Update':'Save'}}</button>
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