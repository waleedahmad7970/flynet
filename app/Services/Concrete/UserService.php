<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

use Carbon\Carbon;

class UserService
{
    // initialize protected model variables
    protected $model_user;

    public function __construct()
    {
        // set the model
        $this->model_user = new Repository(new User);
    }

    public function getUserSource()
    {
        $model = User::with('roles');
        $data = DataTables::of($model)
            ->addColumn('role', function ($item) {
                return $item->roles[0]->name??'';
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->toDayDateTimeString();
            })
            ->addColumn('action', function ($item) {
                return view('users.inc.actions', compact('item'))->render();
            })
            ->rawColumns(['role','action'])
            ->make(true);
        return $data;
    }

    public function allUser(){
        return $this->model_user->getModel()::get();
    }

    public function getAllUsers()
    {
        return $this->model_user->getModel()::select('id', 'name', 'email', 'phone', 'created_at')->with(['roles','permissions'])->get();
    }

    public function save($obj)
    {
        $user = Auth::user();
        if ($obj['id'] != null && $obj['id'] != '') {
            $this->model_user->update($obj, $obj['id']);
            $saved_obj = $this->model_user->find($obj['id']);

            $time = now()->format('h:i A');
            $message = "$time • {$user->name} update user detail {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
            newActivity($message);
        } else {
            $saved_obj = $this->model_user->create($obj);

            $time = now()->format('h:i A');
            $message = "$time • {$user->name} create new user {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
            newActivity($message);
        }

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    public function getById($id)
    {
        return $this->model_user->getModel()::with(['roles','permissions'])->find($id);
    }

    public function getAdminIdsOnly(){
        return User::whereHas('roles', function ($query) {
            $query->where('name', config('enum.superAdmin'));
        })->pluck('id')->toArray();
    }
}
