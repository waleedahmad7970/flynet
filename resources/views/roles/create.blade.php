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
                        <li class="breadcrumb-item"><a href="{{url('roles')}}">Roles</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">
                                    {{isset($role)?'Edit':'Create'}}
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
                                    <h4 class="card-title mb-0">{{isset($role)?'Update':'Add New'}} Role</h4>
                              </div>
                              <form action="{{ url('roles/store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                          <div class="row">
                                                <input type="hidden" name="id" value="{{isset($role)?$role->id:''}}" />
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="name">Role Name<span class="text-danger">*</span> </label>
                                                      <input class="form-control" type="text" name="name" value="{{isset($role)?$role->name:old('name')}}"
                                                            maxlength="50" placeholder="Enter Role name" required />
                                                      @error('name')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                      <label for="permissions">Permissions<span class="text-danger">*</span>
                                                            <button id="selectAll" type="button" class="btn-success" style="border:1px solid #000;">Select All</button>
                                                            <button id="deselectAll" type="button" class="btn-danger" style="border:1px solid #000;">Deselect All</button>
                                                      </label>
                                                      <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple required style="height: 100px;">
                                                            @foreach($permissions as $permission)
                                                            <option value="{{ $permission->name }}" {{ (isset($role) && $role->hasPermissionTo($permission->name)) ? 'selected' : '' }}>{{ $permission->name??'' }}</option>
                                                            @endforeach
                                                      </select>
                                                      @error('permissions')
                                                      <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                </div>

                                          </div>

                                    </div>
                                    <div class="card-footer">

                                          <div class="row">
                                                <div class="col-md-12">
                                                      <a href="{{ url('roles') }}" class="btn btn-danger">Cancel</a>
                                                      <button class="btn btn-primary">{{isset($role)?'Update':'Save'}}</button>
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
@section('js')
<script>
    $(document).ready(function() {

        // Select All Button
        $('#selectAll').on('click', function() {
            let allValues = [];
            $('#permissions option').each(function() {
                allValues.push($(this).val()); // Collect all values
            });
            $('#permissions').val(allValues).trigger('change'); // Set values and trigger change
        });

        // Deselect All Button
        $('#deselectAll').on('click', function() {
            $('#permissions').val(null).trigger('change'); // Clear all selections
        });
    });
</script>
@endsection