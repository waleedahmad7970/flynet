<?php

namespace App\Http\Controllers;

use App\Services\Concrete\RoleService;
use App\Services\Concrete\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

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

    public function index()
    {
        // abort_if(Gate::denies('users_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('users.index');
    }


    public function getData(Request $request)
    {
        // abort_if(Gate::denies('users_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->user_service->getUserSource();
    }

    public function create()
    {
        // abort_if(Gate::denies('users_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = $this->role_service->getAll();
        return view('users.create', compact('roles'));
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

                return redirect()->back()->withErrors($validator)->withInput();
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

            if (!$user)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('users')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id)
    {
        // abort_if(Gate::denies('users_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = $this->user_service->getById($id);
        $roles = $this->role_service->getAll();
        return view('users.create', compact('user', 'roles'));
    }
}
