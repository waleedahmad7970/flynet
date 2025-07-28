@extends('layouts.app')
@section('css')
<style>
      b{
            color:#000;
      }
</style>
@endsection
@section('content')
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

      <div class="row page-titles mx-0">
            <div class="col p-md-0">
                  <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('list-role')}}">Roles</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">View</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">View Role</h4>
                                    <a class="btn btn-primary btn-md m-1" href="{{ url('role/create') }}">
                                          <i class="fa fa-plus text-white mr-2"></i> New Role
                                    </a>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-12">
                                                <b>Name:</b><br>
                                                <span>Admin</span>
                                          </div>
                                          <div class="col-md-12">
                                                <b>Permissions:</b><br>
                                                <span class="badge badge-primary">dashboard</span>
                                                <span class="badge badge-primary">my_camera_access</span>
                                                <span class="badge badge-primary">my_camera_create</span>
                                                <span class="badge badge-primary">my_camera_edit</span>
                                                <span class="badge badge-primary">my_camera_view</span>
                                          </div>
                                          
                                    </div>
                                    <div class="row mt-2">
                                          <div class="col-lg-12 text-right">
                                                <a class="btn btn-warning btn-sm" href="{{ url('role/create') }}">
                                                      <i class="fa fa-edit text-white mr-2"></i> Edit Role
                                                </a>
                                          </div>
                                    </div>
                              </div>
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