<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\PatrolService;
use App\Traits\JsonResponse;
use Illuminate\Support\Facades\Validator;

use Exception;

class PatrolController extends Controller
{
    use JsonResponse;

    protected $patrol_service;

    public function __construct(
        PatrolService  $patrol_service,
    ) {
        $this->patrol_service = $patrol_service;
    }

    public function getPatrols()
    {
        $patrols = $this->patrol_service->getAllPatrols();

        return response()->json([
            'success' => true,
            'patrols' => $patrols
        ], 200);
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('patrols_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:199', 'string', 'unique:patrols,name,' . $request->id],
                'patrol_time' => ['required'],
                'users' => ['required', 'array'],
                'mosaics' => ['required', 'array'],
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
                "patrol_time"   => $request->patrol_time,
                "users"         => $request->users,
                "mosaics"       => $request->mosaics
            ];

            $patrol = $this->patrol_service->save($obj);

            if (!$patrol) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'patrol' => $patrol,
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
        $patrol = $this->patrol_service->getById($id);

        return response()->json([
            'success' => true,
            'patrol' => $patrol
        ], 200);
    }

    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('patrols_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $patrol = $this->patrol_service->updateStatusById($id);
            if ($patrol) {
                return response()->json([
                    'success' => true,
                    'message' => config("enum.status"),
                    'patrol' => $patrol
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
            // abort_if(Gate::denies('patrols_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $patrol = $this->patrol_service->deleteById($id);
            if ($patrol) {
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
