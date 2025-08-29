<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\GroupService;
use App\Services\Concrete\NotificationService;
use App\Services\Concrete\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Exception;

class NotificationController extends Controller
{
    protected $notification_service;
    protected $user_service;
    protected $group_service;

    public function __construct(
        NotificationService  $notification_service,
        UserService $user_service,
        GroupService $group_service
    ) {
        $this->notification_service = $notification_service;
        $this->user_service = $user_service;
        $this->group_service = $group_service;
    }

    public function getNotifications()
    {
        $notifications = $this->notification_service->getNotifications();

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ], 200);
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('cameras_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'max:199', 'string'],
                'link' => ['nullable', 'max:199', 'url'],
                'description' => ['required', 'max:500', 'string'],
                'send_to' => ['required', 'in:user,group'],
                'users' => ['required_if:send_to,user', 'array'],
                'groups' => ['required_if:send_to,group', 'array'],
                'platform' => ['required', 'array', 'min:1']
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $obj = [
                "id"             => $request->id,
                "sender_id"      => auth('sanctum')->user()->id,
                "title"          => $request->title,
                "link"           => $request->link ?? null,
                "description"    => $request->description,
                "platform"       => json_encode($request->platform),
                "status"         => 'open'
            ];

            $notification = $this->notification_service->save($obj);

            if($request->send_to == "user") {
                $notification->users()->attach($request->users);
            } else {
                if(count($request->groups) > 0) {
                    foreach($request->groups as $grp)
                    {
                        $group = $this->group_service->getById($grp);
                        if(count($group->users) > 0) {
                            $notification->users()->attach($group->users);
                        }
                    }
                }
            }

            if (!$notification) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'notification' => $notification,
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
