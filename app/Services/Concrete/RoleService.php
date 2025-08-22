<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleService
{
    // initialize protected model variables
    protected $model_role;

    public function __construct()
    {
        // set the model
        $this->model_role = new Repository(new Role());
    }


    public function getAll(){
        return $this->model_role->all();
    }

    public function getRoleSource()
    {
        $model = Role::get();
        $data = DataTables::of($model)
            ->addColumn('permissions', function ($item) {
                $collect = '';
                if($item->name == "Super-Admin") {
                    $collect = "<span class='btn-success p-1' style='border-radius: 8px;'>all</span>";
                } else {
                    foreach ($item->permissions as $permission) {
                        $collect .= "<span class='btn-success p-1' style='border-radius: 8px;'>" . $permission->name . "</span> ";
                    }
                }
                return $collect;
            })
            ->addColumn('action', function ($item) {
                return view('roles.inc.actions', compact('item'))->render();
            })
            ->rawColumns(['permissions', 'action'])
            ->make(true);
        return $data;
    }

    public function save($obj)
    {
        $user = Auth::user();
        if ($obj['id'] != null && $obj['id'] != '') {
            $this->model_role->update($obj, $obj['id']);
            $saved_obj = $this->model_role->find($obj['id']);

            $time = now()->format('h:i A');
            $message = "$time • {$user->name} update role detail {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
            newActivity($message);
        } else {
            $saved_obj = $this->model_role->create($obj);

            $time = now()->format('h:i A');
            $message = "$time • {$user->name} create new permission {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
            newActivity($message);
        }

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    public function getById($id)
    {
        return $this->model_role->getModel()::with('permissions')->find($id);
    }
}
