<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionService
{
    // initialize protected model variables
    protected $model_permission;

    public function __construct()
    {
        // set the model
        $this->model_permission = new Repository(new Permission);
    }

    public function getAll()
    {
        return $this->model_permission->all();
    }

    public function getPermissionSource()
    {
        $model = Permission::get();
        $data = DataTables::of($model)
            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='btn btn-warning btn-sm mr-2' href='permissions/edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";

                // if(Auth::user()->can('permissions_edit'))
                $action_column .= $edit_column;

                return $action_column;
            })
            ->rawColumns(['action'])
            ->make(true);
        return $data;
    }

    public function save($obj)
    {
        $user = Auth::user();
        if ($obj['id'] != null && $obj['id'] != '') {
            $this->model_permission->update($obj, $obj['id']);
            $saved_obj = $this->model_permission->find($obj['id']);

            $time = now()->format('h:i A');
            $message = "$time • {$user->name} update permission detail {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
            newActivity($message);
        } else {
            $saved_obj = $this->model_permission->create($obj);

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
        return $this->model_permission->find($id);
    }
}
