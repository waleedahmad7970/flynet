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
                                                            <th>OS</th>
                                                            <th>Storage</th>
                                                            <th>Network</th>
                                                            <th>Performance</th>
                                                            <th>Online</th>
                                                            <th>Action</th>
                                                      </tr>
                                                </thead>
                                                <tbody>
                                                      <tr>
                                                            <td>{{ $server_details['server_name'] }}</td>
                                                            <td>189 / 300</td>
                                                            <td>{{ $server_details['cpu']['model'] }} <span class="badge badge-success">{{ $server_details['cpu']['usage_percent'] . '%' }}</span></td>
                                                            <td>{{ $server_details['memory']['used_gb'] }} GB / {{ $server_details['memory']['total_gb'] }} GB <span class="badge badge-success">{{ $server_details['memory']['used_percentage'] . '%' }}</span></td>
                                                            <td>{{ $server_details['os'] }}</td>
                                                            <td>{{ $server_details['storage']['used_gb'] }} GB / {{ $server_details['storage']['total_gb'] }} GB <span class="badge badge-success">{{ $server_details['storage']['used_percentage'] . '%' }}</span></td>
                                                            <td><span class="fas fa-arrow-down" style="color:red;"></span> {{ $server_details['network_MB']['received_MB'] }} Mbps / {{ $server_details['network_MB']['sent_MB'] }} Mbps <span class="fas fa-arrow-up" style="color:red;"></span></td>
                                                            <td><span class="badge badge-success">Great</span></td>
                                                            <td><span class="fas fa-check" style="color:green;"></span></td>
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
