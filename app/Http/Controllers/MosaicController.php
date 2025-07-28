<?php

namespace App\Http\Controllers;

use App\Services\Concrete\MosaicService;
use App\Services\Concrete\CameraService;
use App\Services\Concrete\UserService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MosaicController extends Controller
{
    use JsonResponse;
    protected $mosaic_service;
    protected $user_service;
    protected $camera_service;
    public function __construct(
        MosaicService  $mosaic_service,
        UserService $user_service,
        CameraService $camera_service
    ) {
        $this->mosaic_service = $mosaic_service;
        $this->user_service = $user_service;
        $this->camera_service = $camera_service;
    }

    public function index()
    {
        // abort_if(Gate::denies('mosaics_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('mosaics.index');
    }


    public function getData(Request $request)
    {
        // abort_if(Gate::denies('mosaics_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->mosaic_service->getMosaicSource($request->all());
    }

    public function create()
    {
        // abort_if(Gate::denies('mosaics_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = $this->user_service->allUser();
        $cameras = $this->camera_service->allActiveCamera();
        return view('mosaics.create', compact('users', 'cameras'));
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('mosaics_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:199', 'string', 'unique:mosaics,name,' . $request->id],
                'type' => ['required', 'string'],
                'no_of_cameras' => ['required'],
                'users' => ['required', 'array'],
                'cameras' => ['required', 'array'],
            ]);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $obj = [
                "id"            => $request->id,
                "name"          => $request->name,
                "type"          => $request->type,
                "no_of_cameras" => $request->no_of_cameras,
                "users"         => $request->users,
                "cameras"       => $request->cameras
            ];

            $mosaic = $this->mosaic_service->save($obj);

            if (!$mosaic)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('mosaics')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id)
    {
        // abort_if(Gate::denies('mosaics_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = $this->user_service->allUser();
        $cameras = $this->camera_service->allActiveCamera();
        $mosaic = $this->mosaic_service->getById($id);
        return view('mosaics.create', compact('mosaic', 'users', 'cameras'));
    }

    public function view($id)
    {
        // abort_if(Gate::denies('mosaics_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $mosaic = $this->mosaic_service->getById($id);
        return view('mosaics.view', compact('mosaic'));
    }

    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('mosaics_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $mosaic = $this->mosaic_service->updateStatusById($id);
            if ($mosaic)
                return  $this->success(
                    config("enum.status"),
                    $mosaic
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
            // abort_if(Gate::denies('mosaics_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $mosaic = $this->mosaic_service->deleteById($id);
            if ($mosaic)
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
