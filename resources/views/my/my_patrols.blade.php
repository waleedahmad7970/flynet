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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">My Patrols</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">My Patrols ({{$patrols->count()}})</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          @foreach($patrols as $item)
                                          <div class="col-md-3">
                                                <a href="{{url('my-patrols/view/'.$item->id)}}">
                                                      <div class="card" style="border: 1px solid #4444;">
                                                            <div class="card-body">
                                                                  <span class="fa fa-list"></span> {{$item->mosaics->count()}} Mosaics <br>
                                                                  <span class="fa fa-watch"></span> {{$item->patrol_time}}s <br>
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