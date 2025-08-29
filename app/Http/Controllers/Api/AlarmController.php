<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\Concrete\AlarmService;

use Exception;

class AlarmController extends Controller
{
    protected $alarm_service;

    public function __construct(
        AlarmService  $alarm_service
    ) {
        $this->alarm_service = $alarm_service;
    }

    public function getAlarms()
    {
        $alarms = $this->alarm_service->getAllAlarms();

        return response()->json([
            'success' => true,
            'alarms' => $alarms
        ], 200);
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

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $obj = [
                "id"            => $request->id,
                "name"          => $request->name,
                "description"   => $request->description,
                "users"         => $request->users,
                "cameras"       => $request->cameras
            ];

            $alarm = $this->alarm_service->save($obj);

            if (!$alarm) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'alarm' => $alarm,
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
        // abort_if(Gate::denies('alarms_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $alarm = $this->alarm_service->getById($id);

        return response()->json([
            'success' => true,
            'alarm' => $alarm
        ], 200);
    }

    public function destroy($id)
    {
        try {
            // abort_if(Gate::denies('alarms_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $alarm = $this->alarm_service->deleteById($id);
            if ($alarm) {
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

    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('alarms_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $alarm = $this->alarm_service->updateStatusById($id);
            if ($alarm) {
                return response()->json([
                    'success' => true,
                    'message' => config("enum.status"),
                    'alarm' => $alarm
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
