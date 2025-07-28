<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use App\Services\Concrete\MosaicService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class MyMosaicController extends Controller
{
    use JsonResponse;
    protected $mosaic_service;
    public function __construct(
        MosaicService  $mosaic_service
    ) {
        $this->mosaic_service = $mosaic_service;
    }

    public function index(Request $request)
    {
        // abort_if(Gate::denies('my_mosaics_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search = $request->input('search');

        $mosaics = $this->mosaic_service->myMosaics();
        
        return view('my.my_mosaics', compact('mosaics'));
    }

    public function view($id)
    {
        // abort_if(Gate::denies('my_mosaics_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $mosaic = $this->mosaic_service->getById($id);

        return view('my.my_mosaic_view', compact('mosaic'));
    }
}
