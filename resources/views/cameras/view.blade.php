@extends('layouts.app')
@section('css')
<style>
	/* .caption {
		margin-top: 15px;
		background: #fff;
		padding: 10px;
		display: inline-block;
		border-radius: 5px;
		font-size: 14px;
		color: #333;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
	} */
    .timeline-wrapper{
        &{
                padding: 15px;
                background: #fff;
                border-radius: 8px;
                margin-bottom: 10px;
        }
        input[type="datetime-local"]{
                border: 1px solid #cacaca;
                border-radius: 20px;
                padding: 4px 10px;
        }
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .time-filters a,.time-filters button {
        background: #f0f0f0;
        border: none;
        padding: 6px 12px;
        margin: 0 4px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }

    .time-filters a.active,.time-filters button.active {
        background: #007bff;
        color: #fff;
    }

    .timeline-bar {
        margin-top: 10px;
        height: 30px;
        background: #e9f3ff;
        position: relative;
        border-radius: 4px;
    }

    .timeline-segment {
        height: 10px;
        position: absolute;
        background: #007bff;
        cursor: pointer;
        border-right: 1px solid #fff;
        transition: background 0.2s;
        min-width: 5%;
        bottom: 0;
    }

    .timeline-segment span{
        color: black;
        top: 15px;
        position: relative;
        left: -17px;
        font-size: 12px;
    }

    .timeline-segment:has(span)::before {
        content:'';
        background:black;
        width: 1px;
        height: 12px;
        display: block;
    }

    .timeline-segment:hover {
        background: #0056b3;
    }

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

    .time-filters a, .time-filters button{
            font-size: 12px
    }


    #timeline-indicator {
        position: absolute;
        top: 0;
        width: 2px;
        height: 100%;
        background: red;
        z-index: 10;
        pointer-events: none;
    }

    #timeline-indicator{
        span {
            width: 60px;
            display: block;
            position: relative;
            top: -20px;
            color: white;
            font-size: 10px;
            background: black;
            padding: 3px 10px;
            left: -30px;
        }
    }

    #timeline-indicator  ::after{
        content: " ";
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-top: 10px solid black;
        position: relative;
        top: 25px;
        left: -27px;
    }

    @media(max-width:768px){
        .timeline-segment{
            span{
                    display:none
            }
        }
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
				<li class="breadcrumb-item"><a href="{{url('cameras')}}">Cameras</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">View Camera</a></li>
			</ol>
		</div>
	</div>
      <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                <script>
                        toastr.success('{{ session('
                            success ') }}');
                </script>
                @endif

                @if(session('error'))
                <script>
                        toastr.error('{{ session('
                            error ') }}');
                </script>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">View Camera</h4>
                    </div>
                    <div class="card-body">
                        <video id="video" width="100%" controls autoplay muted></video>
						<h3 class="mt-2"><b>{{ $camera->name }}</b></h3>

                        <div class="timeline-wrapper">
                            <div class="timeline-header">
                                <div class="d-block w-100">
                                        <h4>{{ $camera->name }}</h4>
                                </div>
                                <div class="time-filters">
                                <button data-range="1440">24 Hours</button>
                                    <button data-range="720">12 Hours</button>
                                    <button data-range="60">1 Hours</button>
                                    <button data-range="30">30 Minutes</button>
                                    <button data-range="5" class="active">5 Minutes</button>
                                    <input id="time_range" name="date_range" onchange="changeDate(this)"
                                    min="{{ now()->subDays(3)->format('Y-m-d\TH:i') }}"
                                    max="{{ now()->format('Y-m-d\TH:i') }}"
                                    value="{{ now()->format('Y-m-d\TH:i') }}"
                                    type="datetime-local">
                                </div>
                            </div>

                            <div id="timeline-bar" class="timeline-bar">
                                <!-- JS will populate segments here -->
                                <div id="timeline-indicator"></div>
                            </div>
                        </div>

                        <div class="caption">
                            🔴 {{ $camera->name ?? '' }}

                            {{-- Show the latest recording download link --}}
                            @php
                            $latestRecording = $camera->recordings()->latest()->first();
                            @endphp

                            @if ($latestRecording)
                            <a href="{{ url('cameras/download-recording/'. $latestRecording->id) }}" class="btn btn-success btn-md m-1">
                                <i class="fa fa-download"></i> Download Last Video
                            </a>
                            @endif

                            {{-- Trigger new recording --}}
                            <button id="recordBtn" class="btn btn-primary btn-md m-1" data-id="{{ $camera->id }}">
                                <i class="fa fa-video"></i> Record New Video
                            </button>
                            <span id="recordTimer" class="ml-2 text-danger font-weight-bold"></span>
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

    const video = document.getElementById('video');

    const HLS_URL = 'http://168.227.22.23:8888/{{ $camera->slug }}/index.m3u8';
    // const videoSrc = 'http://127.0.0.1:8888/{{ $camera->slug }}/index.m3u8';

	// if (Hls.isSupported()) {
	// 	const hls = new Hls({
    //         liveSyncDuration: 3
    //     });
	// 	hls.loadSource(videoSrc);
	// 	hls.attachMedia(video);
	// 	hls.on(Hls.Events.MANIFEST_PARSED, () => video.play());
	// } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
	// 	video.src = videoSrc;
	// 	video.addEventListener('loadedmetadata', () => video.play());
	// } else {
	// 	alert("HLS not supported in this browser.");
	// }

    function setupHls(url)
    {
        if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = url;
        } else if (Hls.isSupported()) {
            const hls = new Hls({ liveSyncDuration: 3 });
            hls.loadSource(url);
            hls.attachMedia(video);

            hls.on(Hls.Events.LEVEL_LOADED, (_, data) => {
                if (data.details.live) {
                    renderTimeline();
                }
            });
        } else {
            alert("HLS not supported in this browser.");
        }
    }

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

    setupHls(HLS_URL);

</script>
<script>
      $(document).ready(function() {
            let interval = null;

            $('#recordBtn').on('click', function() {
                  const $btn = $(this);
                  const cameraId = $btn.data('id');
                  const $timer = $('#recordTimer');

                  // Reset UI
                  $btn.prop('disabled', true).text('Recording...');
                  $timer.text('⏳ 5:00');

                  let secondsLeft = 300;

                  // Clear any previous interval
                  if (interval) clearInterval(interval);

                  // Start countdown
                  interval = setInterval(() => {
                        secondsLeft--;
                        const min = String(Math.floor(secondsLeft / 60)).padStart(2, '0');
                        const sec = String(secondsLeft % 60).padStart(2, '0');
                        $timer.text(`⏳ ${min}:${sec}`);

                        if (secondsLeft <= 0) {
                              clearInterval(interval);
                              interval = null;
                              $btn.prop('disabled', false).html('<i class="fa fa-video"></i> Record New Video');
                              $timer.text('');
                        }
                  }, 1000);

                  // Fire AJAX to trigger Laravel recording
                  $.ajax({
                        url: "{{ url('cameras/recording/') }}/" + cameraId,
                        type: 'GET',
                        success: function(res) {
                              toastr.success(res.message || 'Recording started successfully. File will be available after 5 minutes.');
                        },
                        error: function(xhr) {
                              // Stop timer and reset UI
                              clearInterval(interval);
                              interval = null;

                              $btn.prop('disabled', false).html('<i class="fa fa-video"></i> Record New Video');
                              $timer.text('');

                              let message = 'Recording failed.';
                              if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                              }

                              toastr.error(message);
                        }
                  });
            });
      });
</script>

@endsection
