@extends('layouts.app')

@section('content')
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

      <div class="row page-titles mx-0">
            <div class="col p-md-0">
                  <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('list-notification')}}">Notifications</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Add New Notification</h4>
                              </div>
                              <div class="card-body">
                                    <div class="form-validation">
                                          <form class="form-valide" action="javascript:void(0)" method="post">
                                                <div class="row">
                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <label class="col-form-label" for="title">Title <span class="text-danger">*</span>
                                                                  </label>
                                                                  <input type="text" class="form-control" id="title" name="title" placeholder="Enter title..">
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <label class="col-form-label" for="link">Link <span class="text-danger">*</span>
                                                                  </label>
                                                                  <input type="text" class="form-control" id="link" name="link" placeholder="Enter link..">
                                                            </div>
                                                      </div>
                                                      <div class="col-md-12">
                                                            <div class="form-group">
                                                                  <label class="col-form-label" for="description">Description <span class="text-danger">*</span>
                                                                  </label>
                                                                  <textarea class="form-control" id="description" name="description" placeholder="Enter description.."></textarea>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <label class="col-form-label" for="send_to">Send To <span class="text-danger">*</span>
                                                                  </label>
                                                                  <select class="form-control" name="send_to" id="send_to">
                                                                        <option value="1">Users</option>
                                                                        <option value="2">Groups</option>
                                                                  </select>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <label class="col-form-label" for="platforms">Platforms <span class="text-danger">*</span>
                                                                  </label>
                                                                  <div class="form-check form-switch mr-3">
                                                                        <input class="form-check-input"
                                                                              type="checkbox"
                                                                              role="switch"
                                                                              id="mobile"
                                                                              data-bs-toggle="tooltip"
                                                                              data-bs-placement="bottom"
                                                                              title="Active">
                                                                        <label class="form-check-label" for="mobile">Mobile</label>
                                                                  </div>
                                                                  <div class="form-check form-switch mr-3">
                                                                        <input class="form-check-input"
                                                                              type="checkbox"
                                                                              role="switch"
                                                                              id="web"
                                                                              data-bs-toggle="tooltip"
                                                                              data-bs-placement="bottom"
                                                                              title="Active">
                                                                        <label class="form-check-label" for="web">Web</label>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                            <div class="form-check form-switch mr-3">
                                                                  <input class="form-check-input"
                                                                        type="checkbox"
                                                                        role="switch"
                                                                        id="all_platforms"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom"
                                                                        title="Active">
                                                                  <label class="form-check-label" for="all_platforms">All form the platform</label>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                            <div class="form-check form-switch mr-3">
                                                                  <input class="form-check-input"
                                                                        type="checkbox"
                                                                        role="switch"
                                                                        id="set_as_priority"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom"
                                                                        title="Active">
                                                                  <label class="form-check-label" for="set_as_priority">Set as priority</label>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <label class="col-form-label" for="users">Users <span class="text-danger">*</span>
                                                                  </label>
                                                                  <select class="form-control" name="users" id="users" multiple>
                                                                        <option value="1">John Doe (john@gmail.com)</option>
                                                                        <option value="2">Jane Smith (smith@gmail.com)</option>
                                                                  </select>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                            <div class="form-group">
                                                                  <label class="col-form-label" for="groups">Groups <span class="text-danger">*</span>
                                                                  </label>
                                                                  <select class="form-control" name="groups" id="groups" multiple>
                                                                        <option value="1">Good Group</option>
                                                                        <option value="2">Flynet</option>
                                                                  </select>
                                                            </div>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-lg-12 mt-2">
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                      </div>
                                                </div>
                                          </form>
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
<script>
    $(document).ready(function () {
        // Initially hide both
        $('#users').closest('.form-group').hide();
        $('#groups').closest('.form-group').hide();

        // Show the correct one based on selected value
        function toggleRecipientFields() {
            const sendTo = $('#send_to').val();
            if (sendTo == '1') {
                $('#users').closest('.form-group').show();
                $('#groups').closest('.form-group').hide();
            } else if (sendTo == '2') {
                $('#groups').closest('.form-group').show();
                $('#users').closest('.form-group').hide();
            } else {
                $('#users').closest('.form-group').hide();
                $('#groups').closest('.form-group').hide();
            }
        }

        // Run on page load
        toggleRecipientFields();

        // Run when dropdown changes
        $('#send_to').on('change', function () {
            toggleRecipientFields();
        });
    });
</script>
@endsection
