@extends('layouts.app')
@section('css')
<style>
      .status-button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 16px;
            border: none;
            background-color: #f4f4f4;
            color: #333;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            height: 80px;
            width: 100%;
            transition: all 0.3s ease;
      }

      .status-button .icon {
            font-size: 22px;
      }

      .status-button .text {
            display: flex;
            flex-direction: column;
            text-align: left;
      }

      .status-button .label {
            font-size: 12px;
            color: #666;
      }

      .status-button .count {
            font-size: 20px;
            font-weight: bold;
      }

      .status-button.active {
            background-color: #007bff;
            color: #fff;
      }

      .status-button.active .label {
            color: #fff;
      }

      .status-button:hover {
            transform: scale(1.02);
            cursor: pointer;
      }

      /* Toggle Switch Container */
      .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
      }

      /* Hide default checkbox */
      .switch input {
            opacity: 0;
            width: 0;
            height: 0;
      }

      /* Slider style */
      .slider {
            position: absolute;
            cursor: pointer;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
      }

      /* Toggle knob */
      .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
      }

      /* When checked */
      input:checked+.slider {
            background-color: #28a745;
      }

      input:checked+.slider:before {
            transform: translateX(22px);
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Patrols</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Patrols</h4>
                                    <a class="btn btn-primary btn-md m-1" href="{{ url('patrols/create') }}">
                                          <i class="fa fa-plus text-white mr-2"></i> New Patrol
                                    </a>
                              </div>
                              <div class="card-body">
                                    <div class="table-responsive">
                                          <table id="patrol_table" class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                      <tr>
                                                            <th>Name</th>
                                                            <th>Users</th>
                                                            <th>Mosaics</th>
                                                            <th>Patrol Time</th>
                                                            <th>Created Date</th>
                                                            <th>Active</th>
                                                            <th>Action</th>
                                                      </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                      <tr>
                                                            <th>Name</th>
                                                            <th>Cameras</th>
                                                            <th>Users</th>
                                                            <th>Patrol Time</th>
                                                            <th>Created Date</th>
                                                            <th>Active</th>
                                                            <th>Action</th>
                                                      </tr>
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
@include('includes.datatable', [
'columns' => "
{data: 'name' , name: 'name'},
{data: 'users' , name: 'users', 'sortable': false , searchable: false},
{data: 'mosaics' , name: 'mosaics', 'sortable': false , searchable: false},
{data: 'patrol_time' , name: 'patrol_time'},
{data: 'created_at' , name: 'created_at'},
{data: 'active' , name: 'active' , 'sortable': false , searchable: false},
{data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
'route' => 'patrols/data',
'buttons' => false,
'pageLength' => 10,
'class' => 'patrol_table',
'variable' => 'patrol_table',
])

<script>
      $(document).on('change', '.toggle-status', function() {
            let id = $(this).data('id');

            $.ajax({
                  url: "{{url('patrols/status')}}" + "/" + id,
                  method: 'GET',
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(data) {
                        console.log(data);
                        if (data.Success) {
                              toastr.success(data.Message);
                              initDataTablepatrol_table();
                        } else {
                              toastr.error(data.Message);
                        }
                  },
                  error: function() {
                        toastr.error('Failed to update status.');
                  }
            });
      });

      $(document).on('click', '.delete-patrol', function() {
            let id = $(this).data('id');
            if (!confirm('Are you sure to delete this patrol?')) return;

            $.ajax({
                  url: "{{url('patrols/destroy')}}" + "/" + id,
                  method: 'GET',
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(data) {
                        if (data.Success) {
                              toastr.success(data.Message);
                              initDataTablepatrol_table();
                        } else {
                              toastr.error(data.Message);
                        }
                  },
                  error: function() {
                        toastr.error('Failed to delete.');
                  }
            });
      });
</script>
@endsection