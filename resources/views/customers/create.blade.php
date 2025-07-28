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
                        <li class="breadcrumb-item"><a href="{{url('customers')}}">Customers</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">{{isset($customer)?'Update':'Add New'}} Customer</h4>
                              </div>
                              <form action="{{ url('customers/store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                          <div class="row">
                                                <input type="hidden" name="id" value="{{ isset($customer) ? $customer->id : '' }}" />

                                                {{-- Name --}}
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="name">Name <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="name" name="name"
                                                                  value="{{ old('name', $customer->name ?? '') }}" placeholder="Enter name..">
                                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                                      </div>
                                                </div>

                                                {{-- Company --}}
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="company">Company <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="company" name="company"
                                                                  value="{{ old('company', $customer->company ?? '') }}" placeholder="Enter company..">
                                                            @error('company') <span class="text-danger">{{ $message }}</span> @enderror
                                                      </div>
                                                </div>

                                                {{-- Email --}}
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="email">Email <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="email" name="email"
                                                                  value="{{ old('email', $customer->email ?? '') }}" placeholder="Enter email..">
                                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                                      </div>
                                                </div>

                                                {{-- File Upload --}}
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="document">Document</label>
                                                            <input type="file" class="form-control" id="document" name="document">
                                                            @error('document') <span class="text-danger">{{ $message }}</span> @enderror

                                                            @if(isset($customer) && $customer->file)
                                                            <small class="d-block mt-2">
                                                                  <strong>Existing File:</strong>
                                                                  <a href="{{ asset($customer->file) }}" target="_blank">View Document</a>
                                                            </small>
                                                            @endif
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="card-footer">
                                          <div class="row">
                                                <div class="col-md-12">
                                                      <a href="{{ url('customers') }}" class="btn btn-danger">Cancel</a>
                                                      <button class="btn btn-primary">{{ isset($customer) ? 'Update' : 'Save' }}</button>
                                                </div>
                                          </div>
                                    </div>
                              </form>

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