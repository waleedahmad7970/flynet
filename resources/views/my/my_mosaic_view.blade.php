@extends('layouts.app')
@section('css')
<style>
      .caption {
            margin-top: 15px;
            background: #fff;
            padding: 10px;
            display: inline-block;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
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
                        <li class="breadcrumb-item"><a href="{{url('my-mosaics')}}">My Mosaics</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Mosaic View</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">View Mosaic</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          @foreach($mosaic->cameras as $index=>$item)
                                          <div class="col-md-6">
                                                <video id="video-{{ $index }}" width="100%" controls autoplay muted></video>
                                          </div>
                                          @endforeach
                                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    @foreach($mosaic->cameras as $index => $item)
        const video{{ $index }} = document.getElementById('video-{{ $index }}');
        const videoSrc{{ $index }} = 'http://127.0.0.1:8888/{{ $item->slug }}/index.m3u8';

        if (Hls.isSupported()) {
            const hls{{ $index }} = new Hls();
            hls{{ $index }}.loadSource(videoSrc{{ $index }});
            hls{{ $index }}.attachMedia(video{{ $index }});
            hls{{ $index }}.on(Hls.Events.MANIFEST_PARSED, () => video{{ $index }}.play());
        } else if (video{{ $index }}.canPlayType('application/vnd.apple.mpegurl')) {
            video{{ $index }}.src = videoSrc{{ $index }};
            video{{ $index }}.addEventListener('loadedmetadata', () => video{{ $index }}.play());
        }
    @endforeach
</script>
@endsection