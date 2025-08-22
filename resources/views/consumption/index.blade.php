@extends('layouts.app')
@section('css')
<style>
      .form,
      .datatable,
      .actions {
            margin: 20px;
      }

      input,
      select {
            margin: 5px;
            padding: 5px;
      }

      table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
      }

      th,
      td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
      }

      .delete-btn,
      #clear-all {
            background: red;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Consumption Calculator</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Consumption Calculator</h4>
                              </div>
                              <div class="card-body">
                                    <div class="form">
                                          <div class="row">
                                                <div class="col-md-2">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="description">Description </label>
                                                            <input type="text" class="form-control" id="description" placeholder="Description">
                                                      </div>
                                                </div>
                                                <div class="col-md-2">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="resDropdown">Resolution </label>
                                                            <select class="form-control" id="resDropdown">
                                                                  <option value="375">(VGA) 375Kbps</option>
                                                                  <option value="1000">(720p) 1Mbps</option>
                                                                  <option value="custom">Custom</option>
                                                            </select>
                                                      </div>
                                                </div>
                                                <div class="col-md-1" id="kbpsDiv">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="kbps">Kpbs </label>
                                                            <input type="number" class="form-control" id="kbps" placeholder="kbps">
                                                      </div>
                                                </div>
                                                <div class="col-md-2">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="cameras">Number of cameras </label>
                                                            <input type="number" class="form-control" id="cameras" placeholder="cameras">
                                                      </div>
                                                </div>
                                                <div class="col-md-2">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="days">Days </label>
                                                            <input type="number" class="form-control" id="days" placeholder="days">
                                                      </div>
                                                </div>
                                                <div class="col-md-2">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="storage">Storage </label>
                                                            <input type="text" class="form-control" disabled id="storage" placeholder="storage">
                                                      </div>
                                                </div>
                                                <div class="col-md-1 mt-5">
                                                      <div class="form-group">
                                                            <button id="add" class="btn btn-primary">+ Add</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <button id="clear-all" class="delete-btn btn btn-danger"><span class="fa fa-trash"></span> To clean</button>
                                    </div>
                                    <div class="table-responsive">
                                          <table class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                      <tr>
                                                            <th>Description</th>
                                                            <th>Resolution (Kbps)</th>
                                                            <th>Number of cameras</th>
                                                            <th>Number of days</th>
                                                            <th>Storage needed</th>
                                                            <th>Actions</th>
                                                      </tr>
                                                </thead>
                                                <tbody id="data-body">
                                                </tbody>
                                                <tfoot>
                                                      <th>Description</th>
                                                      <th>Resolution (Kbps)</th>
                                                      <th>Number of cameras</th>
                                                      <th>Number of days</th>
                                                      <th>Storage needed</th>
                                                      <th>Actions</th>
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
<script>
      function calculateStorage(kbps, cameras, days) {
            const bitsPerSecond = kbps * 1000;
            const totalSeconds = days * 24 * 60 * 60;
            const totalBits = bitsPerSecond * cameras * totalSeconds;
            const totalBytes = totalBits / 8;
            const totalTB = totalBytes / 1e12;
            return totalTB.toFixed(2) + " TB";
      }

      $(document).ready(function() {

            $('#kbpsDiv').hide();

            $('#resDropdown').on('change', function() {
                if ($(this).val() === 'custom') {
                    $('#kbpsDiv').slideDown(); // show with animation
                } else {
                    $('#kbpsDiv').slideUp();   // hide with animation
                }
            });

            $('#add').click(function() {
                  const desc = $('#description').val();
                  const res = $('#resDropdown').val();

                  let kbps;
                  if(res === 'custom') {
                    kbps = parseInt($('#kbps').val());
                  } else {
                    kbps = parseInt(res);
                  }

                  const cams = parseInt($('#cameras').val());
                  const days = parseInt($('#days').val());
                  const storage = calculateStorage(kbps, cams, days);

                  $('#storage').val(storage);

                  const row = `
                                <tr>
                                <td>${desc}</td>
                                <td>${res} (${kbps}Kbps)</td>
                                <td>${cams}</td>
                                <td>${days}</td>
                                <td>${storage}</td>
                                <td><button class="delete-btn"><span class="fa fa-trash"></span></button></td>
                                </tr>
                            `;
                  $('#data-body').append(row);
            });

            $('#data-body').on('click', '.delete-btn', function() {
                  $(this).closest('tr').remove();
            });

            $('#clear-all').click(function() {
                  $('#data-body').empty();
            });
      });
</script>
@endsection
