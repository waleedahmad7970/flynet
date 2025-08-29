<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\CameraService;
use Illuminate\Support\Facades\Validator;
use App\Models\CameraRecording;

use Exception;

class CameraController extends Controller
{
    protected $camera_service;
    public function __construct(
        CameraService  $camera_service
    ) {
        $this->camera_service = $camera_service;
    }

    public function getCameras()
    {
        $cameras = $this->camera_service->getAllCameras();

        return response()->json([
            'success' => true,
            'cameras' => $cameras
        ], 200);
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('cameras_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:199', 'string'],
                'ip_address' => ['required', 'max:100', 'string', 'unique:cameras,ip_address,' . $request->id],
                'protocol' => ['required', 'string', 'max:50'],
                'manufacturer' => ['required', 'string', 'max:50'],
                'location' => ['required', 'string', 'max:199'],
                'longitude' => ['required', 'string', 'max:199'],
                'latitude' => ['required', 'string', 'max:199'],
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $obj = [
                "id"            => $request->id,
                "name"          => $request->name,
                "ip_address"    => $request->ip_address,
                "protocol"      => $request->protocol,
                "manufacturer"  => $request->manufacturer,
                "stream_url"    => $request->stream_url,
                "location"      => $request->location,
                "longitude"     => $request->longitude,
                "latitude"      => $request->latitude,
                "port"          => $request->port ?? null,
                "username"      => $request->username ?? null,
                "password"      => $request->password ?? null
            ];

            $camera = $this->camera_service->save($obj);

            if (!$camera) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'camera' => $camera,
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function view($id)
    {
        $camera = $this->camera_service->getById($id);

        return response()->json([
            'success' => true,
            'camera' => $camera,
        ], 200);
    }

        // destroy
    public function destroy($id)
    {
        try {
            // abort_if(Gate::denies('cameras_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $camera = $this->camera_service->deleteById($id);
            if ($camera) {
                return response()->json([
                    'success' => true,
                    'message' => config('enum.delete'),
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => config("enum.error")
            ], 404);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('cameras_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $camera = $this->camera_service->updateStatusById($id);

            if ($camera) {
                return response()->json([
                    'success' => true,
                    'message' => config("enum.status"),
                    'camera' => $camera
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => config("enum.error"),
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function recording($id)
    {
        try {
            $recorded = $this->camera_service->cameraRecording($id, 300); // 5 minutes = 300 seconds

            if ($recorded) {
                return response()->json(['success' => true, 'message' => 'Recording started successfully.'], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Stream unavailable or failed to start recording.'
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadRecording($id)
    {
        $recording = CameraRecording::findOrFail($id);
        $filePath = storage_path('app/' . $recording->file_path);

        if (!file_exists($filePath)) {
            dd([
                'path_attempted' => $filePath,
                'file_path_from_db' => $recording->file_path
            ]);
            abort(404, 'Recording not found.');
        }

        return response()->download($filePath);
    }
}
