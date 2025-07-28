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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">My Mosaics</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">My Mosaics ({{$mosaics->count()}})</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          @foreach($mosaics as $item)
                                          <div class="col-md-3">
                                                <a href="{{url('my-mosaics/view/'.$item->id)}}">
                                                      <div class="card" style="border: 1px solid #4444;">
                                                            <div class="card-body">
                                                                  <div class="row">
                                                                        <div class="col-md-9">
                                                                              <span class="fa fa-video-camera"></span> {{$item->cameras->count()}}/{{$item->no_of_cameras}} <br>
                                                                              <b style="color:#000;">{{$item->name??''}}</b>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                              <div style="width: 35px; height: 25px; display: flex; flex-wrap: wrap;">
                                                                                    @for ($i = 0; $i < min(8, $item->no_of_cameras); $i++)
                                                                                          <div style="width: 50%; height: 50%; background-color: rgb(0, 150, 252); border: 1px solid #fff;"></div>
                                                                                          @endfor
                                                                              </div>
                                                                        </div>
                                                                  </div>
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