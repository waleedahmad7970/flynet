<?php

namespace App\Http\Controllers;

use App\Services\Concrete\ActivityLogService;
use App\Services\Concrete\CameraService;
use App\Services\Concrete\GroupService;
use App\Services\Concrete\UserService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    use JsonResponse;

    protected $activity_log_service;
    protected $user_service;
    protected $camera_service;
    protected $group_service;

    public function __construct(
        ActivityLogService  $activity_log_service,
        UserService $user_service,
        CameraService $camera_service,
        GroupService $group_service
    ) {
        $this->activity_log_service = $activity_log_service;
        $this->user_service = $user_service;
        $this->camera_service = $camera_service;
        $this->group_service = $group_service;
    }

    public function index()
    {
        $activity_logs = $this->activity_log_service->allActivityLog();
        $users = $this->user_service->allUser();
        $cameras = $this->camera_service->allActiveCamera();
        $groups = $this->group_service->allActiveGroup();

        return view('activity_log.index', compact('activity_logs','users','cameras','groups'));
    }

    public function filter_index(Request $request)
    {
        $request->validate([
            'users' => 'required|array',
            'cameras' => 'required|array',
            'groups' => 'nullable|array', // Optional if not in use yet
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $userIds = $request->input('users', []);
        $cameraIds = $request->input('cameras', []);
        $groupIds = $request->input('groups', []);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $users = $this->user_service->allUser();
        $cameras = $this->camera_service->allActiveCamera();
        $groups = $this->group_service->allActiveGroup();

        // Start query
        $query = ActivityLog::query();

        // Date range filter (using `date` field)
        $query->whereBetween('date', [$startDate, $endDate]);

        // Filter by user names in description
        if (!empty($userIds)) {
            $selectedUsers = $users->whereIn('id', $userIds);
            $query->where(function ($q) use ($selectedUsers) {
                foreach ($selectedUsers as $user) {
                    $q->orWhere('description', 'LIKE', '%' . $user->name . '%');
                }
            });
        }

        // Filter by camera names in description
        if (!empty($cameraIds)) {
            $selectedCameras = $cameras->whereIn('id', $cameraIds);
            $query->where(function ($q) use ($selectedCameras) {
                foreach ($selectedCameras as $camera) {
                    $q->orWhere('description', 'LIKE', '%' . $camera->name . '%');
                }
            });
        }

        // (Optional) Filter by group names if you store them similarly
        if (!empty($groupIds)) {
            $selectedGroups = $groups->whereIn('id', $groupIds);
            $query->where(function ($q) use ($selectedGroups) {
                foreach ($selectedGroups as $group) {
                    $q->orWhere('description', 'LIKE', '%' . $group->name . '%');
                }
            });
        }

        $activity_logs = $query->latest()->get();

        return view('activity_log.index', compact('activity_logs','users','cameras','groups'));
    }
}
