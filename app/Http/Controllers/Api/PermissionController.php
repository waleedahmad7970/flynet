<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\PermissionService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Exception;

class PermissionController extends Controller
{
    protected $permission_service;
    public function __construct(
        PermissionService  $permission_service
    ) {
        $this->permission_service = $permission_service;
    }

    public function getPermissions()
    {
        $permissions = $this->permission_service->getApiPermissions();

        return response()->json([
            'success' => true,
            'data' => $permissions
        ], 200);
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('permissions_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'name' => [
                            'required',
                            'max:50',
                            'string',
                            Rule::unique('permissions')->where(function ($query) use ($request) {
                                return $query->where('guard_name', $request->input('guard_name', 'sanctum'));
                            }),
                        ],
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $obj = [
                "id"    => $request->id,
                "name"  => strtolower($request->name)
            ];

            $permission = $this->permission_service->save($obj);

            if (!$permission) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'permission' => $permission,
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
