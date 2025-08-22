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

      .rtsp-entry {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
      }

      .copy-btn {
            float: right;
      }

      .rtsp-url {
            word-break: break-word;
            font-family: monospace;
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Address</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">RTSPs Address List</h4> <br>
                                    <p>Check below for a list of the most popular RTSP addresses on the market.</p>
                              </div>
                              <div class="card-body border">
                                    <div class="form mb-4">
                                        <p>Fill in the fields and then copy the link, according to the manufacturer's brand. Use it when registering a new camera on the platform.</p>
                                          <div class="row">
                                                <div class="col-md-4">
                                                      <input type="text" class="form-control" id="user" placeholder="User">
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                      <p>User to access the camera (e.g., admin).</p>
                                                </div>
                                          </div>

                                          <div class="row">
                                                <div class="col-md-4">
                                                      <input type="text" class="form-control" id="password" placeholder="Password">
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                      <p>Password of the user to access the camera (e.g., 1234).</p>
                                                </div>
                                          </div>

                                          <div class="row">
                                                <div class="col-md-4">
                                                      <input type="text" class="form-control" id="domain" placeholder="Domain">
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                      <p>Network IP or DDNS (e.g., camera.ddns.com or 192.168.1.10).</p>
                                                </div>
                                          </div>

                                          <div class="row">
                                                <div class="col-md-4">
                                                      <input type="text" class="form-control" id="port" placeholder="Port">
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                      <p>RTSP port (usually 554).</p>
                                                </div>
                                          </div>

                                          <div class="row">
                                                <div class="col-md-4">
                                                      <input type="text" class="form-control" id="manufacturer" placeholder="Manufacturer (optional)">
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                      <p>Filter by camera manufacturer.</p>
                                                </div>
                                          </div>

                                          {{-- <button class="btn btn-primary mt-3" onclick="generateRTSP()">Generate RTSP Links</button> --}}
                                    </div>

                                    <!-- Output Area -->
                                    <div id="output"></div>
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
      const rtspList = [{
                  brand: 'Tenda - IT7-L PCS',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/profile0'
            },
            {
                  brand: 'Tecvoz – TW Câmeras IP',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/profile1'
            },
            {
                  brand: 'Tecvoz – TW DVR/NVR',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/chID=1&streamType=main&linkType=tcpa'
            },
            {
                  brand: 'Tecvoz – T1/THK DVR/NVR',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/Streaming/Channels/01'
            },
            {
                  brand: 'Tecvoz - TVZ DVR',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp'
            },
            {
                  brand: 'Tecvoz - Tecvoz TV Cameras IP',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=1'
            },
            {
                  brand: 'Tecvoz – T1/THK Câmeras IP',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/Streaming/Channels/101'
            },
            {
                  brand: 'Tecvoz – ICB Inteligente Câmeras IP',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/mode=real&idc=1&ids=1'
            },
            {
                  brand: 'Alive',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp?real_stream'
            },
            {
                  brand: 'Axis',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/axis-media/media.amp?videocodac=h264'
            },
            {
                  brand: 'Clear',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp'
            },
            {
                  brand: 'Dahua',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp?'
            },
            {
                  brand: 'Dahua IMOU',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/cam/realmonitor?channel=1&subtype=0'
            },
            {
                  brand: 'Foscan',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/videoMain'
            },
            {
                  brand: 'Greatek',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp'
            },
            {
                  brand: 'GIGA 1',
                  url: 'rtsp://DOMAIN:PORT/user=USER&amp;password=PASSWORD&amp;channel=1&amp;stream=0.sdp'
            },
            {
                  brand: 'GIGA 2',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp'
            },
            {
                  brand: 'HDL',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp'
            },
            {
                  brand: 'Hikvision 1',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/h264/ch1/main/av_stream'
            },
            {
                  brand: 'Hikvision 2',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/Streaming/Channels/101'
            },
            {
                  brand: 'HeroSpeed DVR',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/snap.jpg'
            },
            {
                  brand: 'JFL',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/h264/ch1/main/av_stream'
            },
            {
                  brand: 'Intelbras 1',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/cam/realmonitor?channel=1&subtype=0'
            },
            {
                  brand: 'Intelbras 2',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp?'
            },
            {
                  brand: 'Jortan',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp'
            },
            {
                  brand: 'LG',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/Master-0'
            },
            {
                  brand: 'LuxVision',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp'
            },
            {
                  brand: 'Multilaser',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/H264?ch=1&subtype=0'
            },
            {
                  brand: 'Venetian 1',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp?'
            },
            {
                  brand: 'Venetian 2',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/cam/realmonitor?channel=1&subtype=0&unicast=true&proto=Onvif'
            },
            {
                  brand: 'Vivotek',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/live.sdp'
            },
            {
                  brand: 'TWG',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp?'
            },
            {
                  brand: 'Zavio',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/video.pro1'
            },
            {
                  brand: 'RTSP Genérico 1',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT'
            },
            {
                  brand: 'RTSP Genérico 2',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/h264?channel=1'
            },
            {
                  brand: 'RTSP Genérico 3',
                  url: 'rtsp://DOMAIN:PORT/user=USER&password=PASSWORD&channel=1&stream=0.sdp'
            },
            {
                  brand: 'RTSP Genérico 4',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/onvif1'
            },
            {
                  brand: 'EZView Main',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/unicast/c1/s1/live'
            },
            {
                  brand: 'EZView Sub',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/unicast/c1/s2/live'
            },
            {
                  brand: 'EZView IPC Main',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/media/video1'
            },
            {
                  brand: 'EZView IPC Sub',
                  url: 'rtsp://USER:PASSWORD@DOMAIN:PORT/media/video2'
            },
      ];

      const inputs = document.querySelectorAll("input");

      function showRtsp()
      {
            const output = document.getElementById('output');

            rtspList.forEach((item, index) => {
                  const div = document.createElement('div');
                  div.className = 'rtsp-entry';
                  div.innerHTML = `<strong>${item.brand}</strong>
          <button class="btn btn-sm btn-outline-primary copy-btn" onclick="copyToClipboard('rtsp${index}')">Copy</button>
          <div class="rtsp-url mt-2" id="rtsp${index}">${item.url}</div>
        `;
                output.appendChild(div);
            });

      }

      function generateRTSP() {
            const user = document.getElementById('user').value || 'USER';
            const password = document.getElementById('password').value || 'PASSWORD';
            const domain = document.getElementById('domain').value || 'DOMAIN';
            const port = document.getElementById('port').value || '554';
            const manufacturer = document.getElementById('manufacturer').value.toLowerCase();

            const output = document.getElementById('output');
            output.innerHTML = '';

            const filtered = rtspList.filter(item =>
                  manufacturer === '' || item.brand.toLowerCase().includes(manufacturer)
            );

            if (filtered.length === 0) {
                  output.innerHTML = '<p>No RTSP formats matched the manufacturer.</p>';
                  return;
            }

            filtered.forEach(({
                  brand,
                  url
            }, index) => {
                  const replacedUrl = url
                        .replace(/USER/g, user)
                        .replace(/PASSWORD/g, password)
                        .replace(/DOMAIN/g, domain)
                        .replace(/PORT/g, port);

                  const div = document.createElement('div');
                  div.className = 'rtsp-entry';
                  div.innerHTML = `
          <strong>${brand}</strong>
          <button class="btn btn-sm btn-outline-primary copy-btn" onclick="copyToClipboard('rtsp${index}')">Copy</button>
          <div class="rtsp-url mt-2" id="rtsp${index}">${replacedUrl}</div>
        `;
                  output.appendChild(div);
            });
      }

      showRtsp();

      inputs.forEach(input => input.addEventListener("input", generateRTSP));

      function copyToClipboard(id) {
            const text = document.getElementById(id).textContent;
            navigator.clipboard.writeText(text).then(() => {
                  alert("Copied: " + text);
            });
      }
</script>
@endsection
