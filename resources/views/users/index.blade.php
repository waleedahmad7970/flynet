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
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                         @endif
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Users</h4>
                                    <div>
                                        @if (auth()->user()->can('add users'))
                                            <a class="btn btn-primary btn-md m-1" href="{{ route('users.create') }}">
                                                <i class="fa fa-plus text-white mr-2"></i> New User
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('add reports'))
                                            <button class="btn btn-outline-primary btn-md m-1" data-toggle="modal" data-target="#myModal">
                                                Generate Report
                                            </button>
                                        @endif
                                    </div>
                              </div>
                              <div class="card-body">
                                    <div class="table-responsive">
                                          <table id="user_table" class="table table-striped display" style="width:100%">
                                                <thead>
                                                      <tr>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Role</th>
                                                            <th scope="col">Last Updated</th>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('reports.users.csv') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label for="description">Description<span class="text-danger">*</span> </label>
                            <input class="form-control" type="text" name="description" maxlength="199" placeholder="Enter a description" required />
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="reports">Reports<span class="text-danger">*</span> </label>
                            <select class="form-control" disabled name="reports" id="reports" required>
                                <option value="reports">Reports</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button type="submit" class="btn btn-danger">Generate Reports</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
@include('includes.datatable', [
        'columns' => "
         {data: 'name' , name: 'name'},
         {data: 'email' , name: 'email'},
         {data: 'role' , name: 'role'},
         {data: 'updated_at' , name: 'Last Updated'},
        {data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
        'route' => 'users/data',
        'buttons' => false,
        'pageLength' => 10,
        'class' => 'user_table',
        'variable' => 'user_table',
    ])
@endsection
