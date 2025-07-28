<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use App\Services\Concrete\CameraService;
use Illuminate\Http\Request;

class MyCameraRecordingController extends Controller
{
    protected $camera_service;
    public function __construct(
        CameraService  $camera_service
    ) {
        $this->camera_service = $camera_service;
    }

    public function index(Request $request)
    {
        // abort_if(Gate::denies('my_videos_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search = $request->input('search');

        $camera_recordings = $this->camera_service->myCameraRecording();

        if ($search) {
            $camera_recordings = $camera_recordings->filter(function ($camera_recording) use ($search) {
                return stripos($camera_recording->file_name, $search) !== false;
            });
        }

        return view('my.my_videos', compact('camera_recordings'));
    }

    public function view(Request $request, $id)
    {
        // abort_if(Gate::denies('my_videos_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $search = $request->input('search');

        $camera_recordings = $this->camera_service->myCameraRecording();

        if ($search) {
            $camera_recordings = $camera_recordings->filter(function ($camera_recording) use ($search) {
                return stripos($camera_recording->file_name, $search) !== false;
            });
        }
        $camera_recording = $this->camera_service->getCameraRecordingById($id);

        return view('my.my_video_view', compact('camera_recording', 'camera_recordings'));
    }
}
