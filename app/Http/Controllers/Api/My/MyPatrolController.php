<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\PatrolService;

class MyPatrolController extends Controller
{
    protected $patrol_service;

    public function __construct(
        PatrolService  $patrol_service
    ) {
        $this->patrol_service = $patrol_service;
    }

    public function getMyPatrols(Request $request)
    {
        // abort_if(Gate::denies('my_patrols_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $patrols = $this->patrol_service->myPatrols();

        return response()->json([
            'success' => 200,
            'patrols' => $patrols,
        ], 200);
    }

    public function view($id)
    {
        $patrol = $this->patrol_service->getById($id);

        return response()->json([
            'success' => 200,
            'patrol' => $patrol,
        ], 200);
    }
}
