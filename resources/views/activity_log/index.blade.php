@extends('layouts.app')
@section('css')
<style>
      ul.timeline {
            list-style-type: none;
            position: relative;
      }

      ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
      }

      ul.timeline>li {
            padding-left: 20px;
      }

      ul.timeline>li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Activity Logs</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Activity Log</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          @foreach($activity_logs as $date => $items)
                                          <div class="col-md-12 mb-4">
                                                <h5 class="badge badge-primary" style="font-size: 16px;">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h5>
                                                <ul class="timeline" style="padding: 0px;">
                                                      @foreach($items as $log)
                                                      <li>
                                                            <span class="float-right">
                                                                  <span class="fas fa-clock"></span>
                                                                  {{ \Carbon\Carbon::parse($log->date . ' ' . $log->time)->diffForHumans() }}
                                                            </span>
                                                            <p style="margin-left:30px;">
                                                                  {{ $log->description }}
                                                            </p>
                                                      </li>
                                                      @endforeach
                                                </ul>
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
@section('js')

@endsection