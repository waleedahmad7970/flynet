<?php

namespace App\Http\Controllers;

use App\Services\Concrete\MosaicService;
use App\Services\Concrete\PatrolService;
use App\Services\Concrete\UserService;
use App\Traits\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PatrolController extends Controller
{
    use JsonResponse;
    protected $patrol_service;
    protected $user_service;
    protected $mosaic_service;
    public function __construct(
        PatrolService  $patrol_service,
        UserService $user_service,
        MosaicService $mosaic_service
    ) {
        $this->patrol_service = $patrol_service;
        $this->user_service = $user_service;
        $this->mosaic_service = $mosaic_service;
    }

    public function index()
    {
        // abort_if(Gate::denies('patrols_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('patrols.index');
    }


    public function getData(Request $request)
    {
        // abort_if(Gate::denies('patrols_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->patrol_service->getPatrolSource($request->all());
    }

    public function create()
    {
        // abort_if(Gate::denies('patrols_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = $this->user_service->allUser();
        $mosaics = $this->mosaic_service->allActiveMosaic();
        return view('patrols.create', compact('users', 'mosaics'));
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

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $obj = [
                "id"            => $request->id,
                "name"          => $request->name,
                "patrol_time"   => $request->patrol_time,
                "users"         => $request->users,
                "mosaics"       => $request->mosaics
            ];

            $patrol = $this->patrol_service->save($obj);

            if (!$patrol)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('patrols')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id)
    {
        // abort_if(Gate::denies('patrols_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = $this->user_service->allUser();
        $mosaics = $this->mosaic_service->allActiveMosaic();
        $patrol = $this->patrol_service->getById($id);
        return view('patrols.create', compact('patrol', 'users', 'mosaics'));
    }

    public function view($id)
    {
        // abort_if(Gate::denies('patrols_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $patrol = $this->patrol_service->getById($id);
        return view('patrols.view', compact('patrol'));
    }

    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('patrols_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $patrol = $this->patrol_service->updateStatusById($id);
            if ($patrol)
                return  $this->success(
                    config("enum.status"),
                    $patrol
                );

            return  $this->error(
                config("enum.error")
            );
        } catch (Exception $e) {
            return  $this->error(
                $e->getMessage()
            );
        }
    }

    // destroy
    public function destroy($id)
    {
        try {
            // abort_if(Gate::denies('patrols_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $patrol = $this->patrol_service->deleteById($id);
            if ($patrol)
                return  $this->success(
                    config("enum.delete"),
                    []
                );

            return  $this->error(
                config("enum.error")
            );
        } catch (Exception $e) {
            return  $this->error(
                $e->getMessage()
            );
        }
    }
}
