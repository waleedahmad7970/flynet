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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Reports</a></li>
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
                         @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif

                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Reports</h4>
                              </div>
                              <div class="card-body">
                                    <div class="table-responsive">
                                          <table id="report_table" class="table table-striped display" style="width:100%">
                                                <thead>
                                                      <tr>
                                                            <th scope="col">ID</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Type</th>
                                                            <th scope="col">Date</th>
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
         {data: 'id' , name: 'ID'},
         {data: 'description' , name: 'description'},
         {data: 'type' , name: 'type'},
         {data: 'created_at' , name: 'created_at'},
        {data: 'action' , name: 'action' , 'sortable': false , searchable: true},",
        'route' => 'reports/data',
        'buttons' => false,
        'pageLength' => 10,
        'class' => 'report_table',
        'variable' => 'report_table',
    ])
@endsection
