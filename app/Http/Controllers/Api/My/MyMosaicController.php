<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\MosaicService;

class MyMosaicController extends Controller
{
    protected $mosaic_service;

    public function __construct(
        MosaicService  $mosaic_service
    ) {
        $this->mosaic_service = $mosaic_service;
    }

    public function getMyMosaics(Request $request)
    {
        $search = $request->input('search');

        $mosaics = $this->mosaic_service->myMosaics();

        return response()->json([
            'success' => true,
            'mosaics' => $mosaics
        ], 200);
    }

    public function view($id)
    {
        // abort_if(Gate::denies('my_mosaics_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $mosaic = $this->mosaic_service->getById($id);

        return response()->json([
            'success' => true,
            'mosaic' => $mosaic
        ], 200);
    }
}
