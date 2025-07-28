<?php

namespace App\Http\Controllers;

use App\Services\Concrete\AlarmService;
use App\Services\Concrete\CameraService;
use App\Services\Concrete\UserService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AlarmController extends Controller
{
    use JsonResponse;
    protected $alarm_service;
    protected $user_service;
    protected $camera_service;
    public function __construct(
        AlarmService  $alarm_service,
        UserService $user_service,
        CameraService $camera_service
    ) {
        $this->alarm_service = $alarm_service;
        $this->user_service = $user_service;
        $this->camera_service = $camera_service;
    }

    public function index()
    {
        // abort_if(Gate::denies('alarms_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('alarms.index');
    }


    public function getData(Request $request)
    {
        // abort_if(Gate::denies('alarms_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->alarm_service->getAlarmSource($request->all());
    }

    public function create()
    {
        // abort_if(Gate::denies('alarms_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = $this->user_service->allUser();
        $cameras = $this->camera_service->allActiveCamera();
        return view('alarms.create',compact('users','cameras'));
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('alarms_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:199', 'string', 'unique:alarms,name,' . $request->id],
                'description' => ['required', 'string'],
                'users' => ['required', 'array'],
                'cameras' => ['required', 'array'],
            ]);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $obj = [
                "id"            => $request->id,
                "name"          => $request->name,
                "description"   => $request->description,
                "users"         => $request->users,
                "cameras"       => $request->cameras
            ];

            $alarm = $this->alarm_service->save($obj);

            if (!$alarm)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('alarms')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id)
    {
        // abort_if(Gate::denies('alarms_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = $this->user_service->allUser();
        $cameras = $this->camera_service->allActiveCamera();
        $alarm = $this->alarm_service->getById($id);
        return view('alarms.create', compact('alarm','users','cameras'));
    }

    public function view($id)
    {
        // abort_if(Gate::denies('alarms_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $alarm = $this->alarm_service->getById($id);
        return view('alarms.view', compact('alarm'));
    }

    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('alarms_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $alarm = $this->alarm_service->updateStatusById($id);
            if ($alarm)
                return  $this->success(
                    config("enum.status"),
                    $alarm
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
            // abort_if(Gate::denies('alarms_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $alarm = $this->alarm_service->deleteById($id);
            if ($alarm)
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
