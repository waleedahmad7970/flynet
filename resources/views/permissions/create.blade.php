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
                        <li class="breadcrumb-item"><a href="{{url('permissions')}}">Permissions</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">
                        {{isset($permission)?'Edit':'Create'}}
                        </a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        <div class="card mb-4">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">{{isset($permission)?'Update':'Add New'}} Permission</h4>
                              </div>
                              <form action="{{ url('permissions/store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                          <div class="row">
                                                <input type="hidden" name="id" value="{{isset($permission)?$permission->id:''}}" />
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="firstName1">Permission Name<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="text" name="name" value="{{isset($permission)?$permission->name:old('name')}}"
                                                            maxlength="50" placeholder="Enter permission name" required />
                                                      @error('name')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>

                                          </div>

                                    </div>
                                    <div class="card-footer">
                                          <div class="row">
                                                <div class="col-md-12">
                                                      <a href="{{ url('permissions') }}" class="btn btn-danger">Cancel</a>
                                                      <button class="btn btn-primary">{{isset($permission)?'Update':'Save'}}</button>
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