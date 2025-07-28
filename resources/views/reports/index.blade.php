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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Mosaics</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Reports</h4>
                              </div>
                              <div class="card-body">
                                    <div class="table-responsive">
                                          <div class="row">
                                                <div class="col-md-3">
                                                      <a href="javascript:void(0)">
                                                            <div class="card">
                                                                  <div class="card-body">
                                                                        <b>
                                                                              <span class="fa fa-file"></span>
                                                                              <span>My Camera Report</span>
                                                                        </b>
                                                                  </div>
                                                            </div>
                                                      </a>
                                                </div>
                                                <div class="col-md-3">
                                                      <a href="javascript:void(0)">
                                                            <div class="card">
                                                                  <div class="card-body">
                                                                        <b>
                                                                              <span class="fa fa-file"></span>
                                                                              <span>My Patrol Report</span>
                                                                        </b>
                                                                  </div>
                                                            </div>
                                                      </a>
                                                </div>
                                                <div class="col-md-3">
                                                      <a href="javascript:void(0)">
                                                            <div class="card">
                                                                  <div class="card-body">
                                                                        <b>
                                                                              <span class="fa fa-file"></span>
                                                                              <span>My Mosaic Report</span>
                                                                        </b>
                                                                  </div>
                                                            </div>
                                                      </a>
                                                </div>
                                                <div class="col-md-3">
                                                      <a href="javascript:void(0)">
                                                            <div class="card">
                                                                  <div class="card-body">
                                                                        <b>
                                                                              <span class="fa fa-file"></span>
                                                                              <span>Cameras Report</span>
                                                                        </b>
                                                                  </div>
                                                            </div>
                                                      </a>
                                                </div>
                                                <div class="col-md-3">
                                                      <a href="javascript:void(0)">
                                                            <div class="card">
                                                                  <div class="card-body">
                                                                        <b>
                                                                              <span class="fa fa-file"></span>
                                                                              <span>Groups Report</span>
                                                                        </b>
                                                                  </div>
                                                            </div>
                                                      </a>
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
@section('js')

@endsection