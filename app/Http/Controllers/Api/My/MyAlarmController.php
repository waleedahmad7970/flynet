<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\AlarmService;

class MyAlarmController extends Controller
{
    protected $alarm_service;

    public function __construct(
        AlarmService  $alarm_service
    ) {
        $this->alarm_service = $alarm_service;
    }

    public function getMyAlarms(Request $request)
    {
        $search = $request->input('search');

        $alarms = $this->alarm_service->myAlarms();

        return response()->json([
            'success' => true,
            'alarms' => $alarms
        ], 200);
    }
}
