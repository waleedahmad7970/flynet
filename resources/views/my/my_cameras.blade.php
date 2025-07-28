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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">My Cameras</a></li>
                  </ol>
            </div>
      </div>

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">My Cameras</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          <!-- Map Column -->
                                          <div class="col-md-8">
                                                <div id="cameraMap" style="width: 100%; height: 400px; border-radius: 10px;"></div>
                                          </div>

                                          <!-- Camera List Column -->
                                          <div class="col-md-4">
                                                <h5>{{ count($cameras) }} Cameras</h5>
                                                <div class="row">
                                                      <div class="col-md-12">
                                                            <div class="form-group mb-0">
                                                                  <form method="GET" action="{{ route('my-cameras.index') }}" class="mb-3">
                                                                        <div class="input-group">
                                                                              <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search cameras..." style="border-radius: 10px;">
                                                                              <button type="submit" class="input-group-text bg-white text-primary" style="border-radius: 10px;">
                                                                                    <i class="fa fa-search"></i>
                                                                              </button>
                                                                        </div>
                                                                  </form>
                                                            </div>
                                                      </div>

                                                      @foreach($cameras as $camera)
                                                      <div class="col-md-12 mt-2">
                                                            <a href="{{ route('my-cameras.view', ['id' => $camera->id]) }}">
                                                                  <div class="row">
                                                                        <div class="col-md-5 mb-4 mb-md-0">
                                                                              <img alt="Thumbnail" style="width:120px; height: 80px; border-radius: 10px;" src="{{asset('uploads/cameras/1.jpg')}}">
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                              <b class="text-black">{{ $camera->name }}</b>
                                                                        </div>
                                                                  </div>
                                                            </a>
                                                      </div>
                                                      @endforeach

                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>

<!--**********************************
            Content body end
        ***********************************-->
@endsection
@section('js')
<!-- Leaflet Map Libraries -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Map Initialization Script -->
<script type="module">
      document.addEventListener("DOMContentLoaded", function() {
            let cameras = "{{ $cameras }}";
			let camerass = JSON.parse(cameras.replace(/&quot;/g, '"'));
            
            // Default center (first camera or fallback)
            const defaultLat = camerass.length > 0 ? parseFloat(camerass[0].lat) : 0;
            const defaultLng = camerass.length > 0 ? parseFloat(camerass[0].lng) : 0;

            const map = L.map('cameraMap').setView([defaultLat, defaultLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            camerass.forEach(camera => {
                  if (camera.lat && camera.lng) {
                        L.marker([parseFloat(camera.lat), parseFloat(camera.lng)])
                              .addTo(map)
                              .bindPopup(`<a href="/my-cameras/view/${camera.id}"><b>${camera.name}</b></a>`);
                  }
            });
      });
</script>
@endsection