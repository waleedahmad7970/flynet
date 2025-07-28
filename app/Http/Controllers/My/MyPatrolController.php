<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use App\Services\Concrete\PatrolService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class MyPatrolController extends Controller
{
    use JsonResponse;
    protected $patrol_service;
    public function __construct(
        PatrolService  $patrol_service
    ) {
        $this->patrol_service = $patrol_service;
    }

    public function index(Request $request)
    {
        // abort_if(Gate::denies('my_patrols_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patrols = $this->patrol_service->myPatrols();

        return view('my.my_patrols', compact('patrols'));
    }

    public function view($id)
    {
        // abort_if(Gate::denies('my_patrols_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patrol = $this->patrol_service->getById($id);

        return view('my.my_patrol_view', compact('patrol'));
    }
}
