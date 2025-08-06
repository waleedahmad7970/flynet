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
	.time-btn {
		background-color: #f0f0f0; 
		color: #333333; 
		padding: 7px 14px; 
		border: 0; 
		border-radius: 25px; 
		font-weight: 500;
	}
	.time-active {
		background-color: #0096FC !important;
		color: #ffffff !important;
	}
	/* #timelineContainer {
            width: 640px;
            margin: 10px auto;
            text-align: center;
        }
        #timeLabel {
            font-size: 14px;
            margin-top: 5px;
        }
        #timeline {
            width: 100%;
            appearance: none;
            height: 8px;
            background: #2196f3;
            border-radius: 4px;
            outline: none;
            margin-top: 10px;
        } */

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
                              <div class="card-body border">
                                    <video id="video" width="100%" controls autoplay muted></video>
									<h3 class="mt-2"><b>{{ $camera->name }}</b></h3>
                                    <div class="mt-1">
										<button type="button" class="btn btn-outline-secondary time-btn" data-hours="60">1 Hour</button>
										<button type="button" class="btn btn-outline-secondary time-btn" data-hours="30">30 Minutes</button>
										<button type="button" class="btn btn-outline-secondary time-btn" data-hours="15">15 Minutes</button>
										<button type="button" class="btn btn-outline-secondary time-btn" data-hours="10">10 Minutes</button>
										<button type="button" class="btn btn-outline-secondary time-btn time-active" data-hours="5">5 Minutes</button>
										<button 
											type="button" 
											class="btn btn-outline-secondary time-btn" 
											data-toggle="modal" 
											data-target="#intervalModal"
										>
											{{ \Carbon\Carbon::today()->format('d/m/Y') }}
											<i class="mdi mdi-calendar-edit ml-1"></i>
										</button>
                                    </div> 
									<!-- <div id="timelineContainer">
										<input type="range" id="timeline" min="0" max="3600" value="0">
										<div id="timeLabel">00:00:00</div>
									</div> -->
									<!-- <div id="camera-timestamp"></div> -->
																									
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
</div>
<!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->

<!-- Interval Modal -->
<div class="modal fade" id="intervalModal" tabindex="-1" aria-labelledby="intervalModalLabel" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
				<h5 class="modal-title" id="intervalModalLabel">
					<i class="mdi mdi-calendar-edit mr-1"></i>
					Recording Interval
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
      		</div>
      		<div class="modal-body">
        		<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="streamDate" class="font-weight-bold text-dark">Date</label>
							<input type="date" class="form-control" id="streamDate" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="startTime" class="font-weight-bold text-dark">Start</label>
							<input type="time" class="form-control" id="startTime" value="00:00" />
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="endTime" class="font-weight-bold text-dark">End</label>
							<input type="time" class="form-control" id="endTime" value="23:59" />
						</div>
					</div>
				</div>
      		</div>
      		<div class="modal-footer">
				<!-- onclick="loadIntervalStream()" -->
        		<button type="button" class="btn btn-dark">Search</button>
      		</div>
    	</div>
  	</div>
</div>

@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>

    const video = document.getElementById('video');
 
    const videoSrc = 'http://168.227.22.23:8899/streams/{{ $camera->slug }}/index.m3u8';

	const hls = new Hls({
		maxBufferLength: 30,
		maxMaxBufferLength: 60,
		enableWorker: true,
		lowLatencyMode: true
	});
	
	hls.loadSource(videoSrc);
	hls.attachMedia(video);
	let isLiveReady = false;

	if (Hls.isSupported()) {

		hls.on(Hls.Events.MANIFEST_PARSED, () => video.play());

		hls.on(Hls.Events.LEVEL_UPDATED, () => {
			const liveEdge = hls.liveSyncPosition;

			// Wait until HLS.js calculates liveSyncPosition
			if (liveEdge) {

				if (!isLiveReady && hls.liveSyncPosition) {
      				isLiveReady = true;
      				console.log('[✅] Live stream ready at:', hls.liveSyncPosition);
    			}
			}
		});

	} else if (video.canPlayType('application/vnd.apple.mpegurl')) {
		video.src = videoSrc;
		video.addEventListener('loadedmetadata', () => video.play());
	} else {
		alert("HLS not supported in this browser.");
	}

	const hourButtons = document.querySelectorAll('button[data-hours]');

	// Button click event for all seek buttons
  	hourButtons.forEach(button => {
    	button.addEventListener('click', () => {
			if (!isLiveReady) {
				alert('Live stream is not ready yet. Please wait a few seconds.');
				return;
			}

			// Remove 'active' class from all buttons
      		hourButtons.forEach(btn => btn.classList.remove('time-active'));

      		// Add 'active' to clicked button
      		button.classList.add('time-active');

			const minutes = parseInt(button.getAttribute('data-hours'), 10);
			const secondsAgo = minutes * 60;
			const targetTime = hls.liveSyncPosition - secondsAgo;

			// Prevent going below 0
			video.currentTime = Math.max(targetTime, 0);
			console.log(`[⏪] Seeking ${minutes} minutes ago:`, targetTime.toFixed(2));
    	});
  	});

// 	function loadIntervalStream() {
// 		const date = document.getElementById('streamDate').value;
// 		const start = document.getElementById('startTime').value;
// 		const end = document.getElementById('endTime').value;

// 		// if (!date || !start || !end) {
// 		// 	alert("Please select all fields.");
// 		// 	return;
// 		// }

// 		// Convert date & time into full datetime strings (e.g., 2025-07-03T10:00:00)
// 		const startDateTime = `${date}T${start}:00`;
// 		const endDateTime = `${date}T${end}:00`;

// 		// Optional: Convert to UNIX timestamp if your backend uses that
// 		const startTimestamp = new Date(startDateTime).getTime() / 1000;
// 		const endTimestamp = new Date(endDateTime).getTime() / 1000;

// 		console.log('Requested interval:', startDateTime, 'to', endDateTime);
// //		https://yourdomain.com/hls/recorded.m3u8?
// 		// 🔁 Construct a stream URL (modify based on how your backend/API supports it)
// 		const hlsUrl = 'http://127.0.0.1:8000/storage/recordings/cam_1/recorded.m3u8?start=2025-07-04T14:00:00&end=2025-07-04T14:05:00';
// 	//	const hlsUrl = `http://127.0.0.1:8888/recordings/{{ $camera->slug }}/recorded.m3u8?start=${startTimestamp}&end=${endTimestamp}`;
// 		console.log(hlsUrl)

// 		// Load stream
// 		const video = document.getElementById('video');
// 		const hls = new Hls();
// 		hls.loadSource(hlsUrl);
// 		hls.attachMedia(video);
// 	}

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