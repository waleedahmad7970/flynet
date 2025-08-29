<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\PermissionService;
use App\Services\Concrete\RoleService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Exception;

class RoleController extends Controller
{
    protected $role_service;
    protected $permission_service;

    public function __construct(
        RoleService  $role_service,
        PermissionService $permission_service
    ) {
        $this->role_service = $role_service;
        $this->permission_service = $permission_service;
    }

    public function getRoles()
    {
        $data = $this->role_service->getApiRoles();

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => [
                            'required',
                            'max:50',
                            'string',
                            // 'unique:roles,name,' . $request->id
                            Rule::unique('roles')->where(function ($query) use ($request) {
                                return $query->where('guard_name', $request->input('guard_name', 'sanctum'));
                            }),
                        ],
                'permissions' => ['required', 'array'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $obj = [
                "id"    => $request->id,
                "name"  => $request->name
            ];

            $role = $this->role_service->save($obj);
            $role->syncPermissions($request->permissions);

            if (!$role) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'role' => $role,
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
