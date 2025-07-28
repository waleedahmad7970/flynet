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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Access</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Access</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-3">
                                                <div class="card bg-primary">
                                                      <div class="card-body text-center">
                                                            <h3 class="text-white">Total</h3>
                                                            <h2 class="text-white">300</h2>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-3">
                                                <div class="card bg-primary">
                                                      <div class="card-body text-center">
                                                            <h3 class="text-white">Layer</h3>
                                                            <h2 class="text-white">0</h2>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-3">
                                                <div class="card bg-primary">
                                                      <div class="card-body text-center">
                                                            <h3 class="text-white">Remaining</h3>
                                                            <h2 class="text-white">15</h2>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-3">
                                                <div class="card bg-primary">
                                                      <div class="card-body text-center">
                                                            <h3 class="text-white">Used</h3>
                                                            <h2 class="text-white">185</h2>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-3">
                                                <div class="card" style="border:1px solid #444444;">
                                                      <div class="card-header" style="background: #958f8f44;">
                                                            <h3 class="card-title text-center">Cameras</h3>
                                                      </div>
                                                      <div class="card-body text-center">
                                                            <h3>185/200</h3>
                                                            <span>in use / Total</span>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-3">
                                                <div class="card" style="border:1px solid #444444;">
                                                      <div class="card-header" style="background: #958f8f44;">
                                                            <h3 class="card-title text-center">Pre Alarm</h3>
                                                      </div>
                                                      <div class="card-body text-center">
                                                            <h3>0/0</h3>
                                                            <span>in use / Total</span>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-3">
                                                <div class="card" style="border:1px solid #444444;">
                                                      <div class="card-header" style="background: #958f8f44;">
                                                            <h3 class="card-title text-center">Analytical</h3>
                                                      </div>
                                                      <div class="card-body text-center">
                                                            <h3>0/0</h3>
                                                            <span>in use / Total</span>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-3">
                                                <div class="card" style="border:1px solid #444444;">
                                                      <div class="card-header" style="background: #958f8f44;">
                                                            <h3 class="card-title text-center">LPR</h3>
                                                      </div>
                                                      <div class="card-body text-center">
                                                            <h3>0/0</h3>
                                                            <span>in use / Total</span>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-3">
                                                <div class="card" style="border:1px solid #444444;">
                                                      <div class="card-header" style="background: #958f8f44;">
                                                            <h3 class="card-title text-center">LPR on board</h3>
                                                      </div>
                                                      <div class="card-body text-center">
                                                            <h3>0/0</h3>
                                                            <span>in use / Total</span>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-3">
                                                <div class="card" style="border:1px solid #444444;">
                                                      <div class="card-header" style="background: #958f8f44;">
                                                            <h3 class="card-title text-center">Live</h3>
                                                      </div>
                                                      <div class="card-body text-center">
                                                            <h3>0/0</h3>
                                                            <span>in use / Total</span>
                                                      </div>
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