<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\GroupService;
use Illuminate\Support\Facades\Validator;

use Exception;

class GroupController extends Controller
{
    protected $group_service;

    public function __construct(
        GroupService  $group_service
    ) {
        $this->group_service = $group_service;
    }

    public function getGroups()
    {
        $groups = $this->group_service->allGroups();

        return response()->json([
            'success' => true,
            'groups' => $groups
        ], 200);
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

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
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

            if (!$group) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'group' => $group,
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
        // abort_if(Gate::denies('groups_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $group = $this->group_service->getById($id);

        return response()->json([
            'success' => true,
            'group' => $group,
        ], 200);
    }

    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('groups_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $group = $this->group_service->updateStatusById($id);
            if ($group) {
                return response()->json([
                    'success' => true,
                    'message' => config("enum.status"),
                    'group' => $group
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

    // destroy
    public function destroy($id)
    {
        try {
            // abort_if(Gate::denies('groups_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $group = $this->group_service->deleteById($id);
            if ($group) {
                return response()->json([
                    'success' => true,
                    'message' => config("enum.delete"),
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
}
