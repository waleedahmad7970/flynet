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
                        <li class="breadcrumb-item"><a href="{{url('list-camera')}}">My Camera</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Map</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Camera Map</h4>
                              </div>
                              <div class="card-body">
                                    <iframe style="width: 100%; height: 400px;" src="https://www.openstreetmap.org/export/embed.html?bbox=2.292292%2C48.857166%2C2.296495%2C48.859723&layer=mapnik&marker=48.858844%2C2.294351"></iframe>
                                    </body>
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