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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customers</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Customers</h4>
                                    @if (auth()->user()->can('add customers'))
                                        <a class="btn btn-primary btn-md m-1" href="{{ route('customers.create') }}">
                                            <i class="fa fa-plus text-white mr-2"></i> New Customer
                                        </a>
                                    @endif
                              </div>
                              <div class="card-body">
                                    <div class="table-responsive">
                                          <table id="customer_table" class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                      <tr>
                                                            <th>Name</th>
                                                            <th>Company</th>
                                                            <th>Email</th>
                                                            <th>Document</th>
                                                            <th>Created Date</th>
                                                            <th>Action</th>
                                                      </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                      <th>Name</th>
                                                      <th>Company</th>
                                                      <th>Email</th>
                                                      <th>Document</th>
                                                      <th>Created Date</th>
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
@include('includes.datatable', [
'columns' => "
{data: 'name' , name: 'name'},
{data: 'company' , name: 'company'},
{data: 'email' , name: 'email'},
{data: 'file' , name: 'file'},
{data: 'created_at' , name: 'created_at'},
{data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
'route' => 'customers/data',
'buttons' => false,
'pageLength' => 10,
'class' => 'customer_table',
'variable' => 'customer_table',
])

<script>
      $(document).on('click', '.delete-customer', function() {
            let id = $(this).data('id');
            if (!confirm('Are you sure to delete this customer?')) return;

            $.ajax({
                  url: "{{url('customers/destroy')}}" + "/" + id,
                  method: 'GET',
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(data) {
                        if (data.Success) {
                              toastr.success(data.Message);
                              initDataTablecustomer_table();
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
