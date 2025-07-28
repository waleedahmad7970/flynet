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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">My Alarms</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">My Alarms ({{$alarms->count()}})</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          @foreach($alarms as $item)
                                          <div class="col-md-3">
                                                <a href="javascript:void(0)">
                                                      <div class="card" style="border: 1px solid #4444;">
                                                            <div class="card-body">
                                                                  <span class="fa fa-video-camera"></span> {{$item->cameras->count()}} Cameras <br>
                                                                  <span class="fa fa-users"></span> {{$item->users->count()}} User <br>
                                                                  <b style="color:#000;">{{$item->name??''}}</b>
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
      <!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->
@endsection