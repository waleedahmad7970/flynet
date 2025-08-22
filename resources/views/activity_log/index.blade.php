@extends('layouts.app')
@section('css')
<style>

      .col-md-12:last-child ul.timeline:before{
                  display: none;
      }
      ul{
      }
      ul.timeline {
            list-style-type: none;
            position: relative;
      }
      .card h5:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 44px;
            width: 2px;
            height: 11%;
            z-index: 400;
            top: 28px;
      }

      ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 95%;
            z-index: 400;

      }

      ul.timeline>li {
            padding-left: 20px;
      }

      ul.timeline>li:before {
            content: ' ';
            background: black;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 1px solid #22c0e8;
            left: 15px;
            width: 35px;
            height: 35px;
            top: 10px;
            z-index: 400;
      }
      ul.timeline>li p{
                   margin-left: 30px;
                  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
                  border-radius: 3px;
                  margin-top: 0;
                  background: #fff;
                  color: #444;
                  margin-left: 40px !important;
                  position: relative;
                  padding: 10px;
      }
     .user_name {
            font-weight: bold;
            color: #7571f9 !important;
            font-size: 1rem;
      }

      .card{
            background: none;
      }

      .icon-box{
            position: absolute;
            z-index: 1234;
            top: 20px;
            font-size: 15px;
            left: 24px;
            color: #fff;
      }
      .badge{
            font-weight: 400;
            padding: 0.35em 0.75em;
            border-radius: 20px;
      }

      .text-black{
            color: black !important;
      }
      .select2 {
            width: 100% !important;
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Activity Logs</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Activity Log</h4>
                                    <li class="breadcrumb-item active" data-toggle="modal" data-target="#exampleModal"><a href="javascript:void(0)"><i class="fa fa-filter text-black"></i> Filters  </a></li>

                              </div>
                              <div class="card-body">
                                    <div class="row">
                                          @foreach($activity_logs as $date => $items)
                                          <div class="col-md-12">
                                                <h5 class="badge badge-primary" style="font-size: 16px;">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h5>
                                                <ul class="timeline" style="padding: 0px;">
                                                      @foreach($items as $log)
                                                      <li>
                                                            @if(str_contains($log->description, 'camera'))
                                                                 <i class="icon-box fa fa-camera"> </i>
                                                            @elseif(str_contains($log->description, 'patrol'))
                                                                 <i class="icon-box fa fa-video-camera menu-icon"> </i>
                                                            @elseif(str_contains($log->description, 'customer'))
                                                                 <i class="icon-box  fas fa-user menu-icon"></i>
                                                            @elseif(str_contains($log->description, 'permission'))
                                                                 <i class="icon-box fas fa-lock menu-icon"></i>
                                                            @elseif(str_contains($log->description, 'user'))
                                                                 <i class="icon-box fas fa-user menu-icon"></i>
                                                            @elseif(str_contains($log->description, 'role'))
                                                                 <i class="icon-box fas fa-user-secret menu-icon"></i>
                                                            @else
                                                                <i class="icon-box fas fa-exclamation-triangle menu-icon"></i>
                                                            @endif
                                                            <span class="float-right">
                                                                  <span class="fas fa-clock"></span>
                                                                  {{ \Carbon\Carbon::parse($log->date . ' ' . $log->time)->diffForHumans() }}
                                                            </span>
                                                            <p style="margin-left:30px;">
                                                                  {!! $log->description !!}
                                                            </p>
                                                      </li>
                                                      @endforeach
                                                </ul>
                                          </div>
                                          @endforeach

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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
      <form action="{{route('activity-log-filter')}}" method="POST">
                  @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-filter text-black"></i> Filters </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body row">
            <div class="col-md-12">
                  <div class="form-group">
                        <label class="col-form-label" for="users">Users
                        </label>
                        <select class="form-control" name="users[]" id="users" multiple >
                              @foreach($users as $item)
                              <option value="{{$item->id}}" {{ isset($alarm) && $alarm->users->contains($item->id) ? 'selected' : '' }}>{{$item->name}} ({{$item->email}})</option>
                              @endforeach
                        </select>
                        @error('users')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
            </div>
            <div class="col-md-12">
                  <div class="form-group">
                        <label class="col-form-label" for="cameras">Cameras
                        </label>
                        <select class="form-control" name="cameras[]" id="cameras" multiple >
                              @foreach($cameras as $item)
                              <option value="{{$item->id}}" {{ isset($alarm) && $alarm->cameras->contains($item->id) ? 'selected' : '' }}>{{$item->name}}</option>
                              @endforeach
                        </select>
                        @error('cameras')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
            </div>
            <div class="col-md-12">
                  <div class="form-group">
                        <label class="col-form-label" for="groups">Groups
                        </label>
                        <select class="form-control" name="groups[]" id="groups" multiple >
                              @foreach($groups as $item)
                              <option value="{{$item->id}}" {{ isset($alarm) && $alarm->groups->contains($item->id) ? 'selected' : '' }}>{{$item->name}}</option>
                              @endforeach
                        </select>
                        @error('groups')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
            </div>
            <div class="col-md-6">
                  <div class="form-group">
                        <label class="col-form-label" for="start">Start
                        </label>
                        <input type="datetime-local" name="start_date" class="form-control">
                  </div>
            </div>
            <div class="col-md-6">
                  <div class="form-group">
                        <label class="col-form-label" for="end">End
                        </label>
                        <input type="datetime-local" name="end_date" class="form-control">
                  </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </form>
      </div>
    </div>

        @endsection
@section('js')
<script>
          $(document).ready(function() {
            $('#users').select2({
                  placeholder: "Select users",
                  allowClear: true
            });

            $('#cameras').select2({
                  placeholder: "Select cameras",
                  allowClear: true
            });

            $('#groups').select2({
                  placeholder: "Select cameras",
                  allowClear: true
            });
      });
</script>
@endsection
