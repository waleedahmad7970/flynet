@extends('layouts.app')
@section('css')

@endsection
@section('content')
<!--**********************************
            Content body start
        ***********************************-->
 <!-- Video.js Core Styles -->
<link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />

<!-- Playlist UI CSS (horizontal layout) -->
<link href="https://unpkg.com/videojs-playlist-ui/dist/videojs-playlist-ui.css" rel="stylesheet" />


<div class="content-body">

      <div class="row page-titles mx-0">
            <div class="col p-md-0">
                  <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('my-cameras')}}">My Cameras</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">View Camera</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">View Camera</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-8">

                                                @if($recording)
                                                    <div class="mb-3">
                                                        <strong>{{ Carbon\Carbon::parse($recording->start_time)->format('d M Y H:i:s') }} → {{ Carbon\Carbon::parse($recording->end_time)->format('H:i:s') }}</strong>
                                                        <video id="videoPlayer"  class="video-js vjs-default-skin vjs-fluid" controls  preload="auto"   width="100%"  height="400"></video>
                                                        <!-- Playlist Timeline -->
                                                        <div class="vjs-playlist my-3"></div>
                                                    </div>
                                                @else
                                                    <video id="videoPlayer" width="100%" controls autoplay muted></video>
                                                    <div class="caption">
                                                        🔴 {{$camera->name??''}}
                                                        @php
                                                        $latestRecording = $camera->recordings()->latest()->first();
                                                        @endphp

                                                        @if ($latestRecording)
                                                        <a class="btn btn-primary btn-md m-1" href="{{ url('cameras/download-recording/'. $latestRecording->id) }}">
                                                                <i class="fa fa-download"></i> Save Video
                                                        </a>
                                                        @endif
                                                    </div>
                                                @endif
                                                  <div class="timeline-wrapper">
                                                      <div class="timeline-header">
                                                            <div class="d-block w-100">
                                                                <h4>🔴 {{ $camera->name }}</h4>
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


                                          </div>
                                          <div class="col-md-4">
                                                <h5>{{$cameras->count()}} Cameras</h5>
                                                <div class="row">
                                                      <div class="col-md-12">
                                                            <div class="form-group mb-0">
                                                                  <form method="GET" action="{{ route('my-cameras.view', ['id' => $camera->id]) }}" class="mb-3">
                                                                        <div class="input-group">
                                                                              <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search cameras..." style="border-radius: 10px;">
                                                                              <button type="submit" class="input-group-text bg-white text-primary" style="border-radius: 10px;">
                                                                                    <i class="fa fa-search"></i>
                                                                              </button>
                                                                        </div>
                                                                  </form>
                                                            </div>
                                                      </div>
                                                      @foreach($cameras as $item)
                                                      <div class="col-md-12 mt-2">
                                                            <a href="{{ route('my-cameras.view', ['id' => $item->id]) }}">
                                                                  <div class="row">
                                                                        <div class="col-md-5 mb-4 mb-md-0">
                                                                              <img alt="Thumbnail" style="width:120px; height: 80px; border-radius: 10px;" src="{{asset('uploads/cameras/1.jpg')}}">
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                              <b class="text-black">{{ $item->name }}</b>
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
<!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->
@endsection
@section('js')
<!-- Video.js Core -->
<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>

<!-- HLS for .m3u8 streaming if needed -->
{{-- <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script> --}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const player = videojs('videoPlayer', {
            autoplay: true,
            muted: true,
            sources: [{
                src: `http://168.227.22.23:8888/{{$camera->slug}}/index.m3u8`,
                type: 'application/x-mpegURL'
            }]
        });

        // Keep your timeline render call here
        renderTimeline();

        // Handle filter buttons
        document.querySelectorAll('.time-filters button').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.time-filters button').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                renderTimeline(parseInt(this.dataset.range));
            });
        });

        //Render
        function renderTimeline(durationMinutes = 5)
        {

            const now = new Date();
            timelineStartTime = new Date(now.getTime() - durationMinutes * 60000);
            timelineEndTime = new Date();
            const totalMs = timelineEndTime - timelineStartTime;

            const timeline = document.getElementById('timeline-bar');
            timeline.innerHTML = '<div id="timeline-indicator"></div>'; // reset indicator

            const indicator = document.getElementById('timeline-indicator');

            player.off('timeupdate'); // remove any old listeners
            player.on('timeupdate', function () {
                if (!timelineStartTime || !timelineEndTime) return;
                const playbackTime = player.currentTime() * 1000; // ms since start of video
                const currentSrc = player.currentSrc();
                const currentRecording = updated_recordings.find(r => r.src === currentSrc);

                if (currentRecording) {
                    const videoStartOffset = currentRecording.start - timelineStartTime;
                    const currentMsOnTimeline = videoStartOffset + playbackTime;
                    const percentage = (currentMsOnTimeline / totalMs) * 100;
                    indicator.style.left = `${percentage}%`;

                    const actualTime = new Date(timelineStartTime.getTime() + currentMsOnTimeline);
                indicator.innerHTML = `<span>${actualTime.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit', second: '2-digit'})} </span>`;

                }
            });

            let updated_recordings = [];
            $.get("{{route('my-cameras.filter_minutes')}}", {
                _token: '{{ csrf_token() }}',
                id: {{$camera->id}},
                minutes: durationMinutes
            }, function(data) {

                data.forEach(function(rec) {
                    updated_recordings.push({
                        start: new Date(rec.start_time),
                        end: new Date(rec.end_time),
                        src: rec.file_path
                    });
                });

                updated_recordings.forEach((rec, index) => {
                    console.log(rec.end , timelineStartTime);
                    if (rec.end > timelineStartTime && rec.start < timelineEndTime) {
                        const startOffset = Math.max(0, rec.start - timelineStartTime);
                        const endOffset = Math.min(totalMs, rec.end - timelineStartTime);
                        const left = (startOffset / totalMs) * 100;
                        const width = ((endOffset - startOffset) / totalMs) * 100;

                        const div = document.createElement('div');
                        div.className = 'timeline-segment';
                        div.style.left = left + '%';
                        div.style.width = (width + 1) + '%';
                        div.title = `${rec.start.toLocaleTimeString()} - ${rec.end.toLocaleTimeString()}`;
                        div.onclick = () => {
                            player.src({ type: 'video/mp4', src: rec.src });
                            player.play();
                        };


                        const shouldShowLabel = durationMinutes === 5 || index % 5 === 0;
                        if (shouldShowLabel) {
                            const span = document.createElement('span');
                            span.textContent = rec.start.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
                            div.appendChild(span);
                        }
                        timeline.appendChild(div);
                    }
                });
            });
        }
    });


    const recordings = [
        @foreach($recordings as $rec)
        {
            start: new Date("{{ $rec->start_time }}"),
            end: new Date("{{ $rec->end_time }}"),
            src: "{{ asset($rec->file_path) }}"
        },
        @endforeach
    ];

    let timelineStartTime, timelineEndTime;

    function formatTime(seconds)
    {
        const h = Math.floor(seconds / 3600).toString().padStart(2, '0');
        const m = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
        const s = Math.floor(seconds % 60).toString().padStart(2, '0');

        return `${h}:${m}:${s}`;
    }

    function changeDate(el)
    {
        const selectedDate = el.value;
        const currentUrl = new URL(window.location.href);

        // Add or update the change_date parameter
        currentUrl.searchParams.set('change_date', selectedDate);

        // Reload the page with the new parameter
        window.location.href = currentUrl.toString();
    }

</script>

<style>

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
      span{
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

      #timeline-indicator   ::after{
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
