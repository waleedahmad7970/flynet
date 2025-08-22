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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Roles</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        @if (session()->has('message'))
                        <div class="alert alert-success">
                              {{ session()->get('message') }}
                        </div>
                        @endif
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Roles</h4>
                                    @if (auth()->user()->can('add roles'))
                                        <a class="btn btn-primary btn-md m-1" href="{{ route('roles.create') }}">
                                            <i class="fa fa-plus text-white mr-2"></i> New Role
                                        </a>
                                    @endif
                              </div>
                              <div class="card-body">
                                    <div class="table-responsive">
                                          <table id="role_table" class="table table-striped display" style="width:100%">
                                                <thead>
                                                      <tr>
                                                            <th scope="col">Role Name</th>
                                                            <th scope="col">Permissions</th>
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
             {data: 'permissions' , name: 'permissions' , 'sortable': false , searchable: false},
            {data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
        'route' => 'roles/data',
        'buttons' => false,
        'pageLength' => 10,
        'class' => 'role_table',
        'variable' => 'role_table',
    ])
@endsection
