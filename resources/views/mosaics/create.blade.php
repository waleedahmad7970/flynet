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
                        <li class="breadcrumb-item"><a href="{{url('mosaics')}}">Mosaics</a></li>
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
                                    <h4 class="card-title mb-0">{{isset($mosaic)?'Update':'Add New'}} Mosaic</h4>
                              </div>
                              <form action="{{ url('mosaics/store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                    <input type="hidden" name="id" value="{{isset($mosaic)?$mosaic->id:''}}" />
                                          <div class="row">
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="name">Name <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control" value="{{ old('name', $mosaic->name ?? '') }}" id="name" name="name" placeholder="Enter name..">
                                                            @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="Type">Type <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="type" class="form-control" id="type">
                                                                  <option value="Cameras" {{(isset($mosaic) && $mosaic->type=='Cameras')?'selected':''}}>Cameras</option>
                                                            </select>
                                                            @error('type')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="no_of_cameras">Number Of Cameras <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="no_of_cameras" class="form-control" id="no_of_cameras" required>
                                                                  @foreach([1,2,4,6,9,12,16] as $num)
                                                                  <option value="{{ $num }}" {{ (isset($mosaic) && $mosaic->no_of_cameras == $num) ? 'selected' : '' }}>
                                                                        {{ $num }} cameras
                                                                  </option>
                                                                  @endforeach
                                                            </select>
                                                            @error('no_of_cameras')
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
                                                                  <option value="{{$item->id}}" {{ isset($mosaic) && $mosaic->users->contains($item->id) ? 'selected' : '' }}>{{$item->name}} ({{$item->email}})</option>
                                                                  @endforeach
                                                            </select>
                                                            @error('users')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="cameras">Cameras <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-control" name="cameras[]" id="cameras" multiple required>
                                                                  @foreach($cameras as $item)
                                                                  <option value="{{$item->id}}" {{ isset($mosaic) && $mosaic->cameras->contains($item->id) ? 'selected' : '' }}>{{$item->name}}</option>
                                                                  @endforeach
                                                            </select>
                                                            @error('cameras')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="card-footer">

                                          <div class="row">
                                                <div class="col-md-12">
                                                      <a href="{{ url('mosaics') }}" class="btn btn-danger">Cancel</a>
                                                      <button class="btn btn-primary">{{isset($mosaic)?'Update':'Save'}}</button>
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
            $('#users, #cameras').select2();

            let limit = parseInt($('#no_of_cameras').val()); // initial load

            $('#no_of_cameras').on('change', function() {
                  limit = parseInt($(this).val()); // update on change
            });

            $('#cameras').on('change', function() {
                  let selected = $(this).val();

                  if (selected.length > limit) {
                        alert('You can select only ' + limit + ' camera(s).');
                        selected = selected.slice(0, limit); // limit the array
                        $(this).val(selected).trigger('change');
                  }
            });
      });
</script>
@endsection