<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\Concrete\MosaicService;

use Exception;

class MosaicController extends Controller
{
    protected $mosaic_service;

    public function __construct(
        MosaicService  $mosaic_service
    ) {
        $this->mosaic_service = $mosaic_service;
    }

    public function getMosaics()
    {
        $mosaics = $this->mosaic_service->allMosaics();

        return response()->json([
            'success' => true,
            'mosaics' => $mosaics
        ], 200);
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('mosaics_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:199', 'string', 'unique:mosaics,name,' . $request->id],
                'type' => ['required', 'string'],
                'no_of_cameras' => ['required'],
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
                "type"          => $request->type,
                "no_of_cameras" => $request->no_of_cameras,
                "users"         => $request->users,
                "cameras"       => $request->cameras
            ];

            $mosaic = $this->mosaic_service->save($obj);

            if (!$mosaic) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'mosaic' => $mosaic,
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
        // abort_if(Gate::denies('mosaics_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $mosaic = $this->mosaic_service->getById($id);

        return response()->json([
            'success' => true,
            'mosaic' => $mosaic
        ], 200);
    }

    // status update
    public function status($id)
    {
        try {
            // abort_if(Gate::denies('mosaics_status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $mosaic = $this->mosaic_service->updateStatusById($id);
            if ($mosaic) {
                return response()->json([
                    'success' => true,
                    'message' => config("enum.status"),
                    'mosaic' => $mosaic
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
            // abort_if(Gate::denies('mosaics_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $mosaic = $this->mosaic_service->deleteById($id);
            if ($mosaic) {
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
