<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
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

        $cameras = $this->camera_service->myCameras();

        if ($search) {
            $cameras = $cameras->filter(function ($camera) use ($search) {
                return stripos($camera->name, $search) !== false;
            });
        }

        return view('my.my_cameras', compact('cameras'));
    }

    public function view(Request $request, $id)
    {
        // abort_if(Gate::denies('my_cameras_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search = $request->input('search');
        $minutes = $request->input('minutes',5);
        $changeDate = $request->input('change_date');
        $recording = [];

        $cameras = $this->camera_service->myCameras();

        if ($search) {
            $cameras = $cameras->filter(function ($camera) use ($search) {
                return stripos($camera->name, $search) !== false;
            });
        }

        $camera = $this->camera_service->getById($id);

         // Path to camera recordings (public/recordings/cam_{id})
        $directory = public_path("recordings/cam_{$camera->id}");
        if (!is_dir($directory)) {
            $recordings = collect();
            return view('my.my_camera_view', compact('camera', 'cameras', 'recordings','recording'));
        }

        // Scan files
        $allFiles = collect(\File::files($directory));
        $recordings = $allFiles->map(function($file) use ($camera) {
            $filename = $file->getFilename();

            if (preg_match('/(\d{4}-\d{2}-\d{2})_(\d{2})-(\d{2})-(\d{2})-(\d+)\.mp4$/', $filename, $matches)) {
            $datetime = \Carbon\Carbon::createFromFormat(
                'Y-m-d H-i-s.u',
                "{$matches[1]} {$matches[2]}-{$matches[3]}-{$matches[4]}.{$matches[5]}"
            );

            return [
                'file_path' => asset("recordings/cam_{$camera->id}/{$filename}"),
                'start_time' => $datetime,
                'end_time' => $datetime->copy()->addSeconds(60), // 1-min segments
            ];
        }

        return null;

        })->filter()->sortBy('start_time')->values();


        // Handle date filtering
        if ($changeDate) {
            $selectedDateTime = \Carbon\Carbon::parse($changeDate, 'Asia/Karachi');
                $recordings = $recordings->filter(function ($rec) use ($selectedDateTime, $minutes) {
                    return $rec['start_time'] >= $selectedDateTime->copy()->subMinutes($minutes + 1)
                        && $rec['start_time'] <= $selectedDateTime;
                });
        } elseif ($minutes) {
            $recordings = $recordings->filter(function ($rec) use ($minutes) {
                return $rec['start_time'] >= now('Asia/Karachi')->subMinutes($minutes + 1);
            });
        }

        $recording = $recordings->first();

        return view('my.my_camera_view', compact('camera', 'cameras', 'recordings','recording'));
    }

    public function filter_minutes(Request $request)
    {
        $id = $request->id;
        $minutes = $request->minutes ?? 5;

        $camera = $this->camera_service->getById($id);
        $directory = public_path("recordings/cam_{$camera->id}");
        if (!is_dir($directory)) return response()->json([]);

        $files = collect(\File::files($directory));

        $recordings = $files->map(function($file) use ($camera) {
            $filename = $file->getFilename();

            if (preg_match('/(\d{4}-\d{2}-\d{2})_(\d{2})-(\d{2})-(\d{2})-(\d+)\.mp4$/', $filename, $matches)) {
                $datetime = \Carbon\Carbon::createFromFormat(
                    'Y-m-d H-i-s.u',
                    "{$matches[1]} {$matches[2]}-{$matches[3]}-{$matches[4]}.{$matches[5]}",
                    'Asia/Karachi'
                );

                return [
                    'file_path' => asset("recordings/cam_{$camera->id}/{$filename}"),
                    'start_time' => $datetime,
                    'end_time' => $datetime->copy()->addSeconds(60),
                ];
            }
            return null;
        })->filter()->sortBy('start_time')->values();

        $cutoff = now('Asia/Karachi')->subMinutes($minutes + 1);
        $recordings = $recordings->filter(function ($rec) use ($cutoff) {
            return $rec['start_time'] >= $cutoff;
        })->values();

        return response()->json($recordings);
    }

}
