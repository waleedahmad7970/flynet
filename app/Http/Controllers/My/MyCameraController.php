<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use App\Services\Concrete\CameraService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use App\Models\CameraRecording;
use Carbon\Carbon;

class MyCameraController extends Controller
{
    use JsonResponse;
    protected $camera_service;
    public function __construct(
        CameraService  $camera_service
    ) {
        $this->camera_service = $camera_service;
    }

    public function index(Request $request)
    {
        // abort_if(Gate::denies('my_cameras_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search = $request->input('search');

        //   $cameras = $this->camera_service->myCameras();
        $cameras = Camera::query();
        $cameras->select(['id', 'name', 'slug', 'latitude as lat', 'longitude as lng']);

        if($search) {
            $cameras->where('name', 'LIKE', '%'.$search.'%');
        }

        $cameras = $cameras->where('is_active', 1)->where('createdby_id', Auth()->user()->id)->orderBy('created_at', 'DESC')->get();

        /*
        if ($search) {
            $cameras = $cameras->filter(function ($camera) use ($search) {
                return stripos($camera->name, $search) !== false;
            });
        } */

        return view('my.my_cameras', compact('cameras'));
    }

    public function view(Request $request, $id)
    {
        // abort_if(Gate::denies('my_cameras_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search = $request->input('search');
        $minutes = $request->input('minutes');
        $changeDate = $request->input('change_date');

        if (!$minutes) {
            $minutes = 5;
        }

        $recording = null;
        $recordings = [];

        $cameras = $this->camera_service->myCameras();

        if ($search) {
            $cameras = $cameras->filter(function ($camera) use ($search) {
                return stripos($camera->name, $search) !== false;
            });
        }

        $camera = $this->camera_service->getById($id);

        // Handle date filtering
        if ($changeDate) {
            // Parse the datetime-local input format and convert to Carbon instance
            $selectedDateTime = Carbon::parse($changeDate, 'America/New_York');

            // Get recordings from the selected time going back by the specified minutes
            $recordings = CameraRecording::where('camera_id', $camera->id)
                ->where('start_time', '>=', $selectedDateTime->copy()->subMinutes($minutes + 1))
                ->where('start_time', '<=', $selectedDateTime)
                ->orderBy('start_time', 'asc')
                ->get();

        } elseif ($minutes) {
            // Default behavior - get recordings from current time going back
            $recordings = CameraRecording::where('camera_id', $camera->id)
                ->where('start_time', '>=', now('America/New_York')->subMinutes($minutes + 1))
                ->orderBy('start_time', 'asc')
                ->get();
        }

        $recording = $recordings->first();

        return view('my.my_camera_view', compact('camera', 'cameras', 'recording','recordings'));
    }

    public function filter_minutes (Request $request)
    {
        $id = $request->id;
        $minutes = $request->minutes;
        $camera = $this->camera_service->getById($id);

        $recordings = CameraRecording::select('file_path','start_time','end_time')->where('camera_id', $camera->id)
                                    ->where('start_time', '>=', now('America/New_York')->subMinutes($minutes+1))
                                    ->orderBy('start_time', 'asc')
                                    ->get();

        // The original code was invalid PHP syntax and unused.
        // If you want to return the recordings with file_path as a full URL, map them here:
        $recordings = $recordings->map(function($rec) {
            $rec->file_path = asset($rec->file_path);
               // Use America/New_York so the offset is +0500
            $rec->end_time = Carbon::parse($rec->end_time, 'America/New_York')
                                    ->format('D M d Y H:i:s') . ' GMT' . Carbon::parse($rec->end_time, 'America/New_York')->format('O');

            $rec->start_time = Carbon::parse($rec->start_time, 'America/New_York')
                                    ->format('D M d Y H:i:s') . ' GMT' . Carbon::parse($rec->start_time, 'America/New_York')->format('O');

            return $rec;
        });

        $camera = $this->camera_service->getById($id);

        return $recordings;
    }
}
