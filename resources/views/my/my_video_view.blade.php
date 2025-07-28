@extends('layouts.app')
@section('css')
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
                        <li class="breadcrumb-item"><a href="{{url('my-videos')}}">My Videos</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Video View</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">View Video</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-8">
                                                <video width="100%" height="auto" controls>
                                                      <!-- <source src="{{ asset('storage/recordings/' . basename($camera_recording->file_path)) }}" type="video/mp4"> -->
                                                       <source src="{{ asset(storage_path($camera_recording->file_path)) }}" type="video/mp4">
                                                      Your browser does not support the video tag.
                                                </video>
                                                <div class="caption">
                                                      🔴 {{$camera_recording->camera->name??''}}

                                                      @if ($camera_recording)
                                                      <a class="btn btn-primary btn-md m-1" href="{{ url('cameras/download-recording/'. $camera_recording->id) }}">
                                                            <i class="fa fa-download"></i> Save Video
                                                      </a>
                                                      @endif
                                                </div>
                                          </div>
                                          <div class="col-md-4">
                                                <h5>{{$camera_recordings->count()}} Videos</h5>
                                                <div class="row">
                                                      <div class="col-md-12">
                                                            <div class="form-group mb-0">
                                                                  <form method="GET" action="{{ route('my-videos.view', ['id' => $camera_recording->id]) }}" class="mb-3">
                                                                        <div class="input-group">
                                                                              <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search recording..." style="border-radius: 10px;">
                                                                              <button type="submit" class="input-group-text bg-white text-primary" style="border-radius: 10px;">
                                                                                    <i class="fa fa-search"></i>
                                                                              </button>
                                                                        </div>
                                                                  </form>
                                                            </div>
                                                      </div>
                                                      @foreach($camera_recordings as $item)
                                                      <div class="col-md-12 mt-2">
                                                            <a href="{{ route('my-videos.view', ['id' => $item->id]) }}">
                                                                  <div class="row">
                                                                        <div class="col-md-5 mb-4 mb-md-0">
                                                                              <video width="100%" height="auto">
                                                                                    <source src="{{ asset('app/storage/recordings/' . basename($item->file_path)) }}" type="video/mp4">
                                                                                    Your browser does not support the video tag.
                                                                              </video>
                                                                              <!-- <img alt="Thumbnail" style="width:120px; height: 80px; border-radius: 10px;" src="https://1180.servicestream.io:8060/61f7b0d9ae7a/last.jpg"> -->
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                              <b class="text-black">{{$item->file_name??''}}</b>
                                                                        </div>
                                                                  </div>
                                                            </a>
                                                      </div>
                                                      @endforeach
                                                </div>
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