<?php

namespace App\Http\Controllers;

use App\Models\CameraRecording;
use App\Services\Concrete\CameraService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CameraController extends Controller
{
    use JsonResponse;
    protected $camera_service;
    public function __construct(
        CameraService  $camera_service
    ) {
        $this->camera_service = $camera_service;
    }

    public function index()
    {
        // abort_if(Gate::denies('cameras_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('cameras.index');
    }


    public function getData(Request $request)
    {
        // abort_if(Gate::denies('cameras_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->camera_service->getCameraSource($request->all());
    }

    public function getStatusCount()
    {
        try {
            // abort_if(Gate::denies('cameras_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $camera = $this->camera_service->getStatusCounts();
            if ($camera)
                return  $this->success(
                    config("enum.success"),
                    $camera,
                    false
                );

            return  $this->error(
                config("enum.error")
            );
        } catch (Exception $e) {
            return  $this->error(
                $e->getMessage()
            );
        }
    }

    public function create()
    {
        // abort_if(Gate::denies('cameras_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('cameras.create');
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

                return redirect()->back()->withErrors($validator)->withInput();
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

            if (!$camera)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('cameras')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id)
    {
        // abort_if(Gate::denies('cameras_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $camera = $this->camera_service->getById($id);
        return view('cameras.create', compact('camera'));
    }

    public function view($id)
    {
        // abort_if(Gate::denies('cameras_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $mediamtx = $this->camera_service->stopMediaMTX();
        // if ($mediamtx == false) {
        //     return back()->with('error', 'Service not started!');
        // }
        $camera = $this->camera_service->getById($id);
        return view('cameras.view', compact('camera'));
    }

    public function cameraJson(){
        $cameras = $this->camera_service->allActiveCamera();
        $data=[];
        foreach($cameras as $item)
        {
            $data[]=[
                'id'=>$item->id,
                'stream_type'=>$item->protocol??'',
                'stream_url'=>$item->stream_url
            ];
        }
        return response()->json([
            'status' => 'success',
            'cameras' => $data
        ]);
    }

    public function recording($id)
    {
        try {
            $recorded = $this->camera_service->cameraRecording($id, 300); // 5 minutes = 300 seconds

            if ($recorded) {
                return response()->json(['success' => true, 'message' => 'Recording started successfully.']);
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
    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('cameras_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $camera = $this->camera_service->updateStatusById($id);
            if ($camera)
                return  $this->success(
                    config("enum.status"),
                    $camera
                );

            return  $this->error(
                config("enum.error")
            );
        } catch (Exception $e) {
            return  $this->error(
                $e->getMessage()
            );
        }
    }

    // destroy
    public function destroy($id)
    {
        try {
            // abort_if(Gate::denies('cameras_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $camera = $this->camera_service->deleteById($id);
            if ($camera)
                return  $this->success(
                    config("enum.delete"),
                    []
                );

            return  $this->error(
                config("enum.error")
            );
        } catch (Exception $e) {
            return  $this->error(
                $e->getMessage()
            );
        }
    }
}
