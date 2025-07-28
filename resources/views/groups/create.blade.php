@extends('layouts.app')
@section('css')
<style>
      .status-button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 16px;
            border: none;
            background-color: #f4f4f4;
            color: #333;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            height: 80px;
            width: 100%;
            transition: all 0.3s ease;
      }

      .status-button .icon {
            font-size: 22px;
      }

      .status-button .text {
            display: flex;
            flex-direction: column;
            text-align: left;
      }

      .status-button .label {
            font-size: 12px;
            color: #666;
      }

      .status-button .count {
            font-size: 20px;
            font-weight: bold;
      }

      .status-button.active {
            background-color: #007bff;
            color: #fff;
      }

      .status-button.active .label {
            color: #fff;
      }

      .status-button:hover {
            transform: scale(1.02);
            cursor: pointer;
      }

      /* Toggle Switch Container */
      .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
      }

      /* Hide default checkbox */
      .switch input {
            opacity: 0;
            width: 0;
            height: 0;
      }

      /* Slider style */
      .slider {
            position: absolute;
            cursor: pointer;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
      }

      /* Toggle knob */
      .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
      }

      /* When checked */
      input:checked+.slider {
            background-color: #28a745;
      }

      input:checked+.slider:before {
            transform: translateX(22px);
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
                        <li class="breadcrumb-item"><a href="{{url('groups')}}">Groups</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                  </ol>
            </div>
      </div>
      <!-- row -->

      <div class="container-fluid">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        <div class="card">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">{{isset($group)?'Update':'Add New'}} Group</h4>
                              </div>
                              <form action="{{ url('groups/store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                          <input type="hidden" name="id" value="{{isset($group)?$group->id:''}}" />
                                          <div class="row">
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="name">Name <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control" value="{{isset($group)?$group->name:''}}" id="name" name="name" placeholder="Enter name..">
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="comment">Comment <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control" value="{{isset($group)?$group->comment:''}}" id="comment" name="comment" placeholder="Enter comment..">
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="users">Users <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-control" name="users[]" id="users" multiple required>
                                                                  @foreach($users as $item)
                                                                  <option value="{{$item->id}}" {{ isset($group) && $group->users->contains($item->id) ? 'selected' : '' }}>{{$item->name}} ({{$item->email}})</option>
                                                                  @endforeach
                                                            </select>
                                                            @error('users')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label class="col-form-label" for="cameras">Cameras <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-control" name="cameras[]" id="cameras" multiple required>
                                                                  @foreach($cameras as $item)
                                                                  <option value="{{$item->id}}" {{ isset($group) && $group->cameras->contains($item->id) ? 'selected' : '' }}>{{$item->name}}</option>
                                                                  @endforeach
                                                            </select>
                                                            @error('cameras')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-3">
                                                      <label class="switch">
                                                            <input type="checkbox" class="toggle-status" value="1" name="default" id="default" {{ isset($group) && $group->default ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                      </label>
                                                      <label class="form-check-label" for="default">Default</label>
                                                </div>
                                                <div class="col-md-3">
                                                      <label class="switch">
                                                            <input type="checkbox" class="toggle-status" value="1" name="external_default" id="external_default" {{ isset($group) && $group->external_default ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                      </label>
                                                      <label class="form-check-label" for="external_default">External default</label>
                                                </div>
                                                <div class="col-md-3">
                                                      <label class="switch">
                                                            <input type="checkbox" class="toggle-status" value="1" name="is_active" id="is_active" {{ isset($group) && $group->is_active ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                      </label>
                                                      <label class="form-check-label" for="is_active">Active</label>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-12 mb-3">
                                                      <hr>
                                                      <b>Permissions</b> <br>
                                                </div>
                                                <div class="col-md-3">
                                                      <label class="switch">
                                                            <input type="checkbox" class="toggle-status" value="1" name="panic_alert" id="panic_alert" {{ isset($group) && $group->panic_alert ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                      </label>
                                                      <label class="form-check-label" for="panic_alert">Send panic alerts</label>

                                                </div>
                                                <div class="col-md-3">
                                                      <label class="switch">
                                                            <input type="checkbox" class="toggle-status" value="1" name="view_recording" id="view_recording" {{ isset($group) && $group->view_recording ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                      </label>
                                                      <label class="form-check-label" for="view_recording">View recordings</label>
                                                </div>
                                                <div class="col-md-3">
                                                      <label class="switch">
                                                            <input type="checkbox" class="toggle-status" value="1" name="enable_chat" id="enable_chat" {{ isset($group) && $group->enable_chat ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                      </label>
                                                      <label class="form-check-label" for="enable_chat">Enable chat</label>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-12">
                                                      <hr>
                                                      <b>Notifications</b> <br>
                                                </div>
                                                <div class="col-md-3">
                                                      <label class="switch">
                                                            <input type="checkbox" class="toggle-status" value="1" name="panic_notification" id="panic_notification" {{ isset($group) && $group->panic_notification ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                      </label>
                                                      <label class="form-check-label" for="panic_notification">Panic alert</label>
                                                </div>
                                                <div class="col-md-3">
                                                      <label class="switch">
                                                            <input type="checkbox" class="toggle-status" value="1" name="analytical_notification" id="analytical_notification" {{ isset($group) && $group->analytical_notification ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                      </label>
                                                      <label class="form-check-label" for="analytical_notification">Analytical</label>
                                                </div>
                                                <div class="col-md-3">
                                                      <label class="switch">
                                                            <input type="checkbox" class="toggle-status" value="1" name="offline_notification" id="offline_notification" {{ isset($group) && $group->offline_notification ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                      </label>
                                                      <label class="form-check-label" for="offline_notification">Offline camera</label>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="card-footer">

                                          <div class="row">
                                                <div class="col-md-12">
                                                      <a href="{{ url('groups') }}" class="btn btn-danger">Cancel</a>
                                                      <button class="btn btn-primary">{{isset($group)?'Update':'Save'}}</button>
                                                </div>
                                          </div>
                                    </div>
                              </form>

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
      $(document).ready(function() {
            $('#users, #cameras').select2();
      });
</script>
@endsection