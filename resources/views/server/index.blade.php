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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Server</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Server</h4>
                              </div>
                              <div class="card-body">
                                    <div class="table-responsive">
                                          <table class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                      <tr>
                                                            <th>Name</th>
                                                            <th>Cameras</th>
                                                            <th>Processor</th>
                                                            <th>Memory</th>
                                                            <th>System</th>
                                                            <th>Storage</th>
                                                            <th>Network</th>
                                                            <th>Performance</th>
                                                            <th>Online</th>
                                                            <th>Tag</th>
                                                            <th>Action</th>
                                                      </tr>
                                                </thead>
                                                <tbody>
                                                      <tr>
                                                            <td>FlynetES-01</td>
                                                            <td>189 / 300</td>
                                                            <td><span class="badge badge-success">9.5%</span></td>
                                                            <td><span class="badge badge-success">21%</span></td>
                                                            <td>37 GB / 98 GB <span class="badge badge-success">40%</span></td>
                                                            <td>28.29 TB / 232.84 TB <span class="badge badge-success">40%</span></td>
                                                            <td><span class="fas fa-arrow-down" style="color:red;"></span> 347.47 Mbps /  73.62 Mbps <span class="fas fa-arrow-up" style="color:red;"></span></td>
                                                            <td><span class="badge badge-success">Great</span></td>
                                                            <td><span class="fas fa-check" style="color:green;"></span></td>
                                                            <td><a href="#" class="btn btn-info btn-sm"><span class="fa fa-edit"></span></a></td>
                                                            <td>
                                                                  <a href="#" class="btn btn-danger btn-sm"><span class="fa fa-cog"></span></a>
                                                            </td>
                                                      </tr>
                                                </tbody>
                                                <tfoot>
                                                      <th>Name</th>
                                                      <th>Cameras</th>
                                                      <th>Processor</th>
                                                      <th>Memory</th>
                                                      <th>System</th>
                                                      <th>Storage</th>
                                                      <th>Network</th>
                                                      <th>Performance</th>
                                                      <th>Online</th>
                                                      <th>Tag</th>
                                                      <th>Action</th>
                                                </tfoot>
                                          </table>
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