<?php

namespace App\Http\Controllers;

use App\Services\Concrete\ActivityLogService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    use JsonResponse;
    protected $activity_log_service;
    public function __construct(
        ActivityLogService  $activity_log_service
    ) {
        $this->activity_log_service = $activity_log_service;
    }

    public function index()
    {
        $activity_logs = $this->activity_log_service->allActivityLog();
        return view('activity_log.index', compact('activity_logs'));
    }
}
