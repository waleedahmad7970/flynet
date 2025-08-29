<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\CameraService;

class MyCameraController extends Controller
{
    protected $camera_service;

    public function __construct(
        CameraService  $camera_service
    ) {
        $this->camera_service = $camera_service;
    }

    public function getMyCameras(Request $request)
    {
        $search = $request->input('search');

        $cameras = $this->camera_service->myCameras();

        if ($search) {
            $cameras = $cameras->filter(function ($camera) use ($search) {
                return stripos($camera->name, $search) !== false;
            });
        }

        return response()->json([
            'success' => true,
            'cameras' => $cameras
        ], 200);
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

            return response()->json([
                'success' => false,
                'camera' => $camera,
                'cameras' => $cameras,
                'recordings' => $recordings,
                'recording' => $recording
            ], 404);
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
            $selectedDateTime = \Carbon\Carbon::parse($changeDate, 'America/New_York');
                $recordings = $recordings->filter(function ($rec) use ($selectedDateTime, $minutes) {
                    return $rec['start_time'] >= $selectedDateTime->copy()->subMinutes($minutes + 1)
                        && $rec['start_time'] <= $selectedDateTime;
                });
        } elseif ($minutes) {
            $recordings = $recordings->filter(function ($rec) use ($minutes) {
                return $rec['start_time'] >= now('America/New_York')->subMinutes($minutes + 1);
            });
        }

        $recording = $recordings->first();

        return response()->json([
            'success' => 200,
            'camera' => $camera,
            'cameras' => $cameras,
            'recordings' => $recordings,
            'recording' => $recording
        ], 200);
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
                    'America/New_York'
                );

                return [
                    'file_path' => asset("recordings/cam_{$camera->id}/{$filename}"),
                    'start_time' => $datetime,
                    'end_time' => $datetime->copy()->addSeconds(60),
                ];
            }
            return null;
        })->filter()->sortBy('start_time')->values();

        $cutoff = now('America/New_York')->subMinutes($minutes + 1);
        $recordings = $recordings->filter(function ($rec) use ($cutoff) {
            return $rec['start_time'] >= $cutoff;
        })->values();

        return response()->json($recordings);
    }
}
