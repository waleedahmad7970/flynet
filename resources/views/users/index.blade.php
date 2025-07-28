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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Users</h4>
                                    <a class="btn btn-primary btn-md m-1" href="{{ url('users/create') }}">
                                          <i class="fa fa-plus text-white mr-2"></i> New User
                                    </a>
                              </div>
                              <div class="card-body">
                                    <div class="table-responsive">
                                          <table id="user_table" class="table table-striped display" style="width:100%">
                                                <thead>
                                                      <tr>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Phone</th>
                                                            <th scope="col">Role</th>
                                                            <th scope="col">Address</th>
                                                            <th scope="col">Action</th>
                                                      </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
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
@include('includes.datatable', [
        'columns' => "
         {data: 'name' , name: 'name'},
         {data: 'email' , name: 'email'},
         {data: 'phone' , name: 'phone'},
         {data: 'role' , name: 'role'},
         {data: 'address' , name: 'address'},
        {data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
        'route' => 'users/data',
        'buttons' => false,
        'pageLength' => 10,
        'class' => 'user_table',
        'variable' => 'user_table',
    ])
@endsection