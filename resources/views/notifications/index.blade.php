@extends('layouts.app')
@section('css')
<style>
      #accordion {
            .card-header {
                  margin-bottom: 8px;
            }

            .accordion-title {
                  position: relative;
                  display: block;
                  padding: 8px 0 8px 50px;
                  border-radius: 8px;
                  overflow: hidden;
                  text-decoration: none;
                  color: #000;
                  font-size: 16px;
                  font-weight: 700;
                  width: 100%;
                  text-align: left;
                  transition: all 0.4s ease-in-out;

                  i {
                        position: absolute;
                        width: 40px;
                        height: 100%;
                        left: 0;
                        top: 0;
                        color: #000;
                        text-align: center;
                        border-right: 1px solid transparent;
                  }

                  &:hover {
                        padding-left: 60px;
                        color: #000;

                        i {
                              border-right: 1px solid #fff;
                        }
                  }
            }

            [aria-expanded="true"] {
                  background: #7571f9;
                  color: #000;

                  i {
                        color: #000;
                        background: #7571f9;

                        &:before {
                              content: "\f068";
                        }
                  }
            }
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Notifications</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Notfications</h4>
                                    <a class="btn btn-primary btn-md m-1" href="{{ url('notification/create') }}">
                                          <i class="fa fa-plus text-white mr-2"></i> New Notification
                                    </a>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-12">
                                                <div class="container">
                                                      <div id="accordion">
                                                            <div class="card wow fadeInUp" style="visibility: visible; animation-name: fadeInUp; margin-bottom:0px;border: 1px solid #4444;">
                                                                  <div class="card-header p-0" id="heading-240">
                                                                        <button class="btn btn-link accordion-title collapsed" data-toggle="collapse" data-target="#collapse-240" aria-expanded="false" aria-controls="#collapse-240"><i class="fas fa-plus text-center d-flex align-items-center justify-content-center h-100"></i>
                                                                              <span class="float-right" style="margin-right:10px;"><small><span class="fas fa-clock"></span> 14 minutes ago</small></span>
                                                                              Offline camera <span class="badge badge-success">Open</span> <br>
                                                                              <small><span class="fas fa-video"></span> Casa de Ever Reyes Cam1.1</small>
                                                                        </button>
                                                                  </div>
                                                                  <div id="collapse-240" class="collapse " aria-labelledby="heading-240" data-parent="#accordion">
                                                                        <div class="card-body accordion-body">
                                                                              <div class="row">
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified by</b><br>
                                                                                          <small>Platform</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline on</b><br>
                                                                                          <small>13/02/2025 14:00:41</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified on</b><br>
                                                                                          <small>13/02/2025 14:05:45</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Finished in</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline time</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                            <div class="card wow fadeInUp" style="visibility: visible; animation-name: fadeInUp; margin-bottom:0px;border: 1px solid #4444;">
                                                                  <div class="card-header p-0" id="heading-241">
                                                                        <button class="btn btn-link accordion-title collapsed" data-toggle="collapse" data-target="#collapse-241" aria-expanded="false" aria-controls="#collapse-241"><i class="fas fa-plus text-center d-flex align-items-center justify-content-center h-100"></i>
                                                                              <span class="float-right" style="margin-right:10px;"><small><span class="fas fa-clock"></span> 14 minutes ago</small></span>
                                                                              Offline camera <span class="badge badge-success">Open</span> <br>
                                                                              <small><span class="fas fa-video"></span> Casa de Ever Reyes Cam2</small>
                                                                        </button>
                                                                  </div>
                                                                  <div id="collapse-241" class="collapse " aria-labelledby="heading-241" data-parent="#accordion">
                                                                        <div class="card-body accordion-body">
                                                                              <div class="row">
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified by</b><br>
                                                                                          <small>Platform</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline on</b><br>
                                                                                          <small>13/02/2025 14:00:41</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified on</b><br>
                                                                                          <small>13/02/2025 14:05:45</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Finished in</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline time</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                            <div class="card wow fadeInUp" style="visibility: visible; animation-name: fadeInUp; margin-bottom:0px;border: 1px solid #4444;">
                                                                  <div class="card-header p-0" id="heading-242">
                                                                        <button class="btn btn-link accordion-title collapsed" data-toggle="collapse" data-target="#collapse-242" aria-expanded="false" aria-controls="#collapse-242"><i class="fas fa-plus text-center d-flex align-items-center justify-content-center h-100"></i>
                                                                              <span class="float-right" style="margin-right:10px;"><small><span class="fas fa-clock"></span> 14 minutes ago</small></span>
                                                                              Offline camera <span class="badge badge-success">Open</span> <br>
                                                                              <small><span class="fas fa-video"></span> Casa de Ever Reyes Cam 3</small>
                                                                        </button>
                                                                  </div>
                                                                  <div id="collapse-242" class="collapse " aria-labelledby="heading-242" data-parent="#accordion">
                                                                        <div class="card-body accordion-body">
                                                                              <div class="row">
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified by</b><br>
                                                                                          <small>Platform</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline on</b><br>
                                                                                          <small>13/02/2025 14:00:41</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified on</b><br>
                                                                                          <small>13/02/2025 14:05:45</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Finished in</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline time</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                            <div class="card wow fadeInUp" style="visibility: visible; animation-name: fadeInUp; margin-bottom:0px;border: 1px solid #4444;">
                                                                  <div class="card-header p-0" id="heading-243">
                                                                        <button class="btn btn-link accordion-title collapsed" data-toggle="collapse" data-target="#collapse-243" aria-expanded="false" aria-controls="#collapse-243"><i class="fas fa-plus text-center d-flex align-items-center justify-content-center h-100"></i>
                                                                              <span class="float-right" style="margin-right:10px;"><small><span class="fas fa-clock"></span> 14 minutes ago</small></span>
                                                                              Offline camera <span class="badge badge-success">Open</span> <br>
                                                                              <small><span class="fas fa-video"></span> Casa de Ever Reyes Cam4</small>
                                                                        </button>
                                                                  </div>
                                                                  <div id="collapse-243" class="collapse " aria-labelledby="heading-243" data-parent="#accordion">
                                                                        <div class="card-body accordion-body">
                                                                              <div class="row">
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified by</b><br>
                                                                                          <small>Platform</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline on</b><br>
                                                                                          <small>13/02/2025 14:00:41</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified on</b><br>
                                                                                          <small>13/02/2025 14:05:45</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Finished in</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline time</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                            <div class="card wow fadeInUp" style="visibility: visible; animation-name: fadeInUp; margin-bottom:0px;border: 1px solid #4444;">
                                                                  <div class="card-header p-0" id="heading-244">
                                                                        <button class="btn btn-link accordion-title collapsed" data-toggle="collapse" data-target="#collapse-244" aria-expanded="false" aria-controls="#collapse-244"><i class="fas fa-plus text-center d-flex align-items-center justify-content-center h-100"></i>
                                                                              <span class="float-right" style="margin-right:10px;"><small><span class="fas fa-clock"></span> 14 minutes ago</small></span>
                                                                              Offline camera <span class="badge badge-success">Open</span> <br>
                                                                              <small><span class="fas fa-video"></span> Casa de Ever Reyes Cam4</small>
                                                                        </button>
                                                                  </div>
                                                                  <div id="collapse-244" class="collapse " aria-labelledby="heading-244" data-parent="#accordion">
                                                                        <div class="card-body accordion-body">
                                                                              <div class="row">
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified by</b><br>
                                                                                          <small>Platform</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline on</b><br>
                                                                                          <small>13/02/2025 14:00:41</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Notified on</b><br>
                                                                                          <small>13/02/2025 14:05:45</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Finished in</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                          <b>Offline time</b><br>
                                                                                          <small>-</small>
                                                                                    </div>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                            </div>
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