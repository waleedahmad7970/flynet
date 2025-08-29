<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\RoleService;
use App\Services\Concrete\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\MatchOldPassword;

use Exception;

class UserController extends Controller
{
    protected $user_service;
    protected $role_service;
    public function __construct(
        UserService  $user_service,
        RoleService $role_service
    ) {
        $this->user_service = $user_service;
        $this->role_service = $role_service;
    }

    public function getUsers()
    {
        $users = $this->user_service->getAllUsers();

        return response()->json([
            'success' => true,
            'users' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('users_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'max:100', 'string', 'unique:users,email,' . $request->id],
                'phone' => ['required', 'max:100', 'string', 'unique:users,phone,' . $request->id],
                'name' => ['required', 'string', 'max:50'],
                'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
                'role' => ['required'],
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $obj = [
                "id"        => $request->id,
                "name"      => $request->name,
                "email"     => $request->email,
                "phone"      => $request->phone,
                "address"      => $request->address??null,
                "password"  => Hash::make($request->password)
            ];

            $user = $this->user_service->save($obj);
            $user->syncRoles([$request->role]);

            if (!$user) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'user' => $user,
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // abort_if(Gate::denies('users_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'max:100', 'string', 'unique:users,email,' . $id],
                'phone' => ['required', 'max:100', 'string', 'unique:users,phone,' . $id],
                'name' => ['required', 'string', 'max:50'],
                'role' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $obj = [
                "id"        => $request->id,
                "name"      => $request->name,
                "email"     => $request->email,
                "phone"      => $request->phone,
                "address"      => $request->address??null,
            ];

            $user = $this->user_service->save($obj);
            $user->syncRoles([$request->role]);

            if (!$user) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'user' => $user,
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password' => ['required', new MatchOldPassword],
                'password' => ['required', 'string', 'min:6'],
                'password_confirmation' => ['same:password']
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $obj = [
                "id"        => $request->id,
                "password"  => Hash::make($request->password)
            ];

            $user = $this->user_service->save($obj);

            if (!$user) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    }
}
