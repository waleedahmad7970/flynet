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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Cameras</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Cameras</h4>
                                    <a class="btn btn-primary btn-md m-1" href="{{ url('cameras/create') }}">
                                          <i class="fa fa-plus text-white mr-2"></i> New Camera
                                    </a>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-12">
                                                <div class="container mt-2">
                                                      <div class="row g-3" id="status-filters">
                                                            <div class="col-6 col-md">
                                                                  <button class="status-button active w-100" data-status="enabled">
                                                                        <div class="icon"><i class="fas fa-check"></i></div>
                                                                        <div class="text">
                                                                              <div class="label">Enabled</div>
                                                                              <div class="count">0</div>
                                                                        </div>
                                                                  </button>
                                                            </div>

                                                            <div class="col-6 col-md">
                                                                  <button class="status-button w-100" data-status="disabled">
                                                                        <div class="icon"><i class="fas fa-video-slash"></i></div>
                                                                        <div class="text">
                                                                              <div class="label">Disabled</div>
                                                                              <div class="count">0</div>
                                                                        </div>
                                                                  </button>
                                                            </div>

                                                            <div class="col-6 col-md">
                                                                  <button class="status-button w-100" data-status="online">
                                                                        <div class="icon"><i class="fas fa-wifi"></i></div>
                                                                        <div class="text">
                                                                              <div class="label">Online</div>
                                                                              <div class="count">0</div>
                                                                        </div>
                                                                  </button>
                                                            </div>

                                                            <div class="col-6 col-md">
                                                                  <button class="status-button w-100" data-status="offline">
                                                                        <div class="icon"><i class="fas fa-ban"></i></div>
                                                                        <div class="text">
                                                                              <div class="label">Offline</div>
                                                                              <div class="count">0</div>
                                                                        </div>
                                                                  </button>
                                                            </div>

                                                            <div class="col-6 col-md">
                                                                  <button class="status-button w-100" data-status="unstable">
                                                                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                                                                        <div class="text">
                                                                              <div class="label">Unstable</div>
                                                                              <div class="count">0</div>
                                                                        </div>
                                                                  </button>
                                                            </div>
                                                      </div>
                                                </div>

                                          </div>
                                    </div>
                                    <div class="table-responsive">
                                          <table id="camera_table" class="table table-striped display" style="width:100%">
                                                <thead>
                                                      <tr>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">IP</th>
                                                            <th scope="col">Protocol</th>
                                                            <th scope="col">Manufacturer</th>
                                                            <th scope="col">Stream URL</th>
                                                            <th scope="col">Location</th>
                                                            <th scope="col">Longitude</th>
                                                            <th scope="col">Latitude</th>
                                                            <th scope="col">Active</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Created Date</th>
                                                            <th scope="col">Action</th>
                                                      </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                      <tr>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">IP</th>
                                                            <th scope="col">Protocol</th>
                                                            <th scope="col">Manufacturer</th>
                                                            <th scope="col">Stream URL</th>
                                                            <th scope="col">Location</th>
                                                            <th scope="col">Longitude</th>
                                                            <th scope="col">Latitude</th>
                                                            <th scope="col">Active</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Created Date</th>
                                                            <th scope="col">Action</th>
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
{data: 'ip_address' , name: 'ip_address'},
{data: 'protocol' , name: 'protocol'},
{data: 'manufacturer' , name: 'manufacturer'},
{data: 'stream_url' , name: 'stream_url'},
{data: 'location' , name: 'location'},
{data: 'longitude' , name: 'longitude'},
{data: 'latitude' , name: 'latitude'},
{data: 'active' , name: 'active' , 'sortable': false , searchable: false},
{data: 'status' , name: 'status' , 'sortable': false , searchable: false},
{data: 'created_at' , name: 'created_at'},
{data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
'route' => 'cameras/data',
'buttons' => false,
'pageLength' => 10,
'class' => 'camera_table',
'variable' => 'camera_table',
])

<script>
      $('.status-button').on('click', function() {
            $('.status-button').removeClass('active');
            $(this).addClass('active');

            const status = $(this).data('status');
            console.log(status);
            initDataTablecamera_table(status); // Re-initialize with status filter
      });
      // Function to update the count of cameras based on their status
      function updateStatusButtons() {
            $.ajax({
                  url: "{{ url('cameras/status-counts') }}", // Route to get updated counts
                  method: 'GET',
                  success: function(data) {
                        console.log(data);
                        if (data.Success) {
                              var data = data.Data;
                              // Update the status button counts dynamically
                              $('.status-button[data-status="enabled"] .count').text(data.enabled);
                              $('.status-button[data-status="disabled"] .count').text(data.disabled);
                              $('.status-button[data-status="online"] .count').text(data.online);
                              $('.status-button[data-status="offline"] .count').text(data.offline);
                              $('.status-button[data-status="unstable"] .count').text(data.unstable);
                        } else {
                              toastr.error('Failed to update status counts.');
                        }
                  },
                  error: function() {
                        toastr.error('Failed to fetch status counts.');
                  }
            });
      }

      // Initialize the status button counts on page load
      $(document).ready(function() {
            updateStatusButtons(); // Fetch and display the initial counts
      });

      $(document).on('change', '.toggle-status', function() {
            let id = $(this).data('id');

            $.ajax({
                  url: "{{url('cameras/status')}}" + "/" + id,
                  method: 'GET',
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(data) {
                        console.log(data);
                        if (data.Success) {
                              toastr.success(data.Message);
                              initDataTablecamera_table();
                        } else {
                              toastr.error(data.Message);
                        }
                  },
                  error: function() {
                        toastr.error('Failed to update status.');
                  }
            });
      });

      $(document).on('click', '.delete-camera', function() {
            let id = $(this).data('id');
            if (!confirm('Are you sure to delete this camera?')) return;

            $.ajax({
                  url: "{{url('cameras/destroy')}}" + "/" + id,
                  method: 'GET',
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(data) {
                        if (data.Success) {
                              toastr.success(data.Message);
                              initDataTablecamera_table();
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