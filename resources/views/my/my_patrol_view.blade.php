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
                        <li class="breadcrumb-item"><a href="{{url('my-patrols')}}">My Patrols</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Patrol View</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">View Patrol</h4>
                              </div>
                              <div class="card-body">
                                    <div id="mosaic-container">
                                          <div class="col-md-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                      <h4 class="mb-0" id="mosaic-name">{{ $patrol->mosaics[0]->name ?? '' }}</h4>
                                                      <small><strong>Next switch in: <span id="patrol-timer">{{ $patrol->patrol_time }}</span>s</strong></small>
                                                </div>
                                                <br>
                                          </div>

                                          <div id="mosaic-container">
                                                @foreach($patrol->mosaics as $mosaicIndex => $mosaic)
                                                <div class="mosaic-group" style="{{ $mosaicIndex !== 0 ? 'display: none;' : '' }}">
                                                      <div class="row">
                                                            @foreach($mosaic->cameras as $cameraIndex => $camera)
                                                            <div class="col-md-6">
                                                                  <video id="video-{{ $mosaicIndex }}-{{ $cameraIndex }}" width="100%" controls autoplay muted></video>
                                                            </div>
                                                            @endforeach
                                                      </div>
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
<!-- #/ container -->
</div>
<input type="hidden" id="mosaic-data" value='{{json_encode($patrol->mosaics->pluck("name")->values())}}'>
<!--**********************************
            Content body end
        ***********************************-->
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    const mosaicGroups = document.querySelectorAll('.mosaic-group');
    const mosaicNames = JSON.parse($("#mosaic-data").val());
    const patrolTimeSeconds = Number("{{ $patrol->patrol_time }}");
    const mosaicNameEl = document.getElementById('mosaic-name');
    const timerDisplay = document.getElementById('patrol-timer');

    let currentIndex = 0;
    let timeLeft = patrolTimeSeconds;

    function showMosaic(index) {
        mosaicGroups.forEach(group => group.style.display = 'none');
        mosaicGroups[index].style.display = 'block';
        mosaicNameEl.textContent = mosaicNames[index];
    }

    function switchMosaic() {
        currentIndex = (currentIndex + 1) % mosaicGroups.length;
        showMosaic(currentIndex);
        timeLeft = patrolTimeSeconds;
    }

    showMosaic(currentIndex);

    setInterval(() => {
        timeLeft--;
        if (timeLeft <= 0) {
            switchMosaic();
        }
        timerDisplay.textContent = timeLeft;
    }, 1000);

    // Load HLS for all cameras in all mosaics
    @foreach($patrol->mosaics as $mosaicIndex => $mosaic)
        @foreach($mosaic->cameras as $cameraIndex => $camera)
            const videoEl_{{ $mosaicIndex }}_{{ $cameraIndex }} = document.getElementById('video-{{ $mosaicIndex }}-{{ $cameraIndex }}');
            const streamSrc_{{ $mosaicIndex }}_{{ $cameraIndex }} = 'http://127.0.0.1:8888/{{ $camera->slug }}/index.m3u8';

            if (Hls.isSupported()) {
                const hls_{{ $mosaicIndex }}_{{ $cameraIndex }} = new Hls();
                hls_{{ $mosaicIndex }}_{{ $cameraIndex }}.loadSource(streamSrc_{{ $mosaicIndex }}_{{ $cameraIndex }});
                hls_{{ $mosaicIndex }}_{{ $cameraIndex }}.attachMedia(videoEl_{{ $mosaicIndex }}_{{ $cameraIndex }});
                hls_{{ $mosaicIndex }}_{{ $cameraIndex }}.on(Hls.Events.MANIFEST_PARSED, () => videoEl_{{ $mosaicIndex }}_{{ $cameraIndex }}.play());
            } else if (videoEl_{{ $mosaicIndex }}_{{ $cameraIndex }}.canPlayType('application/vnd.apple.mpegurl')) {
                videoEl_{{ $mosaicIndex }}_{{ $cameraIndex }}.src = streamSrc_{{ $mosaicIndex }}_{{ $cameraIndex }};
                videoEl_{{ $mosaicIndex }}_{{ $cameraIndex }}.addEventListener('loadedmetadata', () => videoEl_{{ $mosaicIndex }}_{{ $cameraIndex }}.play());
            }
        @endforeach
    @endforeach
</script>


@endsection