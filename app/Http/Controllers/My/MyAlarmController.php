<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use App\Services\Concrete\AlarmService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class MyAlarmController extends Controller
{
    use JsonResponse;
    protected $alarm_service;
    public function __construct(
        AlarmService  $alarm_service
    ) {
        $this->alarm_service = $alarm_service;
    }

    public function index(Request $request)
    {
        // abort_if(Gate::denies('my_cameras_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search = $request->input('search');

        $alarms = $this->alarm_service->myAlarms();

        return view('my.my_alarms', compact('alarms'));
    }
}
