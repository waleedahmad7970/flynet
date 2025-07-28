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
                        <li class="breadcrumb-item"><a href="{{url('patrols')}}">Patrols</a></li>
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
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">{{isset($patrol)?'Update':'Add New'}} Patrol</h4>
                              </div>
                              <form action="{{ url('patrols/store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                    <input type="hidden" name="id" value="{{isset($patrol)?$patrol->id:''}}" />
                                          <div class="row">
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="name">Name <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control" value="{{ old('name', $patrol->name ?? '') }}" id="name" name="name" placeholder="Enter name..">
                                                            @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="patrol_time">Patrol Time (s) <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="number" class="form-control" name="patrol_time" value="{{ old('name', $patrol->patrol_time ?? '') }}" id="patrol_time" required>
                                                            @error('patrol_time')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="users">Users <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-control" name="users[]" id="users" multiple required>
                                                                  @foreach($users as $item)
                                                                  <option value="{{$item->id}}" {{ isset($patrol) && $patrol->users->contains($item->id) ? 'selected' : '' }}>{{$item->name}} ({{$item->email}})</option>
                                                                  @endforeach
                                                            </select>
                                                            @error('users')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="mosaics">Mosaics <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-control" name="mosaics[]" id="mosaics" multiple required>
                                                                  @foreach($mosaics as $item)
                                                                  <option value="{{$item->id}}" {{ isset($patrol) && $patrol->mosaics->contains($item->id) ? 'selected' : '' }}>{{$item->name}}</option>
                                                                  @endforeach
                                                            </select>
                                                            @error('mosaics')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="card-footer">

                                          <div class="row">
                                                <div class="col-md-12">
                                                      <a href="{{ url('patrols') }}" class="btn btn-danger">Cancel</a>
                                                      <button class="btn btn-primary">{{isset($patrol)?'Update':'Save'}}</button>
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
            $('#users, #mosaics').select2();
      });
</script>
@endsection