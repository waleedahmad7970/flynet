<?php

namespace App\Http\Controllers;

use App\Services\Concrete\CameraService;
use App\Services\Concrete\GroupService;
use App\Services\Concrete\UserService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class GroupController extends Controller
{
    use JsonResponse;
    protected $group_service;
    protected $user_service;
    protected $camera_service;
    public function __construct(
        GroupService  $group_service,
        UserService $user_service,
        CameraService $camera_service
    ) {
        $this->group_service = $group_service;
        $this->user_service = $user_service;
        $this->camera_service = $camera_service;
    }

    public function index()
    {
        // abort_if(Gate::denies('groups_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('groups.index');
    }


    public function getData(Request $request)
    {
        // abort_if(Gate::denies('groups_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->group_service->getGroupSource($request->all());
    }

    public function create()
    {
        // abort_if(Gate::denies('groups_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = $this->user_service->allUser();
        $cameras = $this->camera_service->allActiveCamera();
        return view('groups.create', compact('users', 'cameras'));
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('groups_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:199', 'string', 'unique:groups,name,' . $request->id],
                'comment' => ['required', 'string'],
                'users' => ['required', 'array'],
                'cameras' => ['required', 'array'],
            ]);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $obj = [
                "id"            => $request->id,
                "name"          => $request->name,
                "comment"       => $request->comment,
                "users"         => $request->users,
                "cameras"       => $request->cameras,
                "default"       => isset($request->default) ? 1 : 0,
                "external_default"          => isset($request->external_default) ? 1 : 0,
                "is_active"                 => isset($request->is_active) ? 1 : 0,
                "panic_alert"               => isset($request->panic_alert) ? 1 : 0,
                "view_recording"            => isset($request->view_recording) ? 1 : 0,
                "enable_chat"               => isset($request->enable_chat) ? 1 : 0,
                "panic_notification"        => isset($request->panic_notification) ? 1 : 0,
                "analytical_notification"   => isset($request->analytical_notification) ? 1 : 0,
                "offline_notification"      => isset($request->offline_notification) ? 1 : 0
            ];

            $group = $this->group_service->save($obj);

            if (!$group)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('groups')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id)
    {
        // abort_if(Gate::denies('groups_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = $this->user_service->allUser();
        $cameras = $this->camera_service->allActiveCamera();
        $group = $this->group_service->getById($id);
        return view('groups.create', compact('group', 'users', 'cameras'));
    }

    public function view($id)
    {
        // abort_if(Gate::denies('groups_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $group = $this->group_service->getById($id);
        return view('groups.view', compact('group'));
    }

    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('groups_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $group = $this->group_service->updateStatusById($id);
            if ($group)
                return  $this->success(
                    config("enum.status"),
                    $group
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
            // abort_if(Gate::denies('groups_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $group = $this->group_service->deleteById($id);
            if ($group)
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
