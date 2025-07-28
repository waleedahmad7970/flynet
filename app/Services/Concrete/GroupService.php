<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class GroupService
{
      // initialize protected model variables
      protected $model_group;

      public function __construct()
      {
            // set the model
            $this->model_group = new Repository(new Group);
      }

      public function getGroupSource($data)
      {
            $model = $this->model_group->getModel()::with([
                  'users',
                  'cameras'
            ]);

            $data = DataTables::of($model)
                  ->addColumn('users', function ($item) {
                        return $item->users ? $item->users->count() : 0;
                  })
                  ->addColumn('cameras', function ($item) {
                        return $item->cameras ? $item->cameras->count() : 0;
                  })
                  ->addColumn('default', function ($item) {
                        return ($item->default==1)?"<span class='fas fa-check text-success'></span>":"<span class='fas fa-close text-danger'></span>";
                  })
                  ->addColumn('active', function ($item) {
                        $checked = $item->is_active ? 'checked' : '';
                        return "<label class='switch'>
                                <input type='checkbox' class='toggle-status' data-id='{$item->id}' {$checked}>
                                <span class='slider round'></span>
                            </label>";
                  })
                  ->addColumn('action', function ($item) {
                        $action_column = '';
                        $edit_column    = "<a class='btn btn-warning btn-sm mr-2' href='groups/edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                        // $view_column    = "<a class='btn btn-info btn-sm mr-2' href='groups/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                        $delete_column = "<button class='btn btn-danger btn-sm delete-mosaic' data-id='{$item->id}'><i class='fa fa-trash'></i> Delete</button>";
                        // if(Auth::user()->can('groups_edit'))
                        $action_column .= $edit_column;

                        // if(Auth::user()->can('groups_view'))
                        // $action_column .= $view_column;

                        // if(Auth::user()->can('groups_delete'))
                        $action_column .= $delete_column;


                        return $action_column;
                  })
                  ->rawColumns(['users','cameras','default','active', 'action'])
                  ->make(true);
            return $data;
      }
      public function allActiveGroup()
      {
            return $this->model_group->getModel()::where('is_active',1)->get();
      }

      public function save($obj)
      {
            $user = Auth::user();
            if ($obj['id'] != null && $obj['id'] != '') {
                  $obj['updatedby_id'] = $user->id;
                  $this->model_group->update($obj, $obj['id']);
                  $saved_obj = $this->model_group->find($obj['id']);
                  $saved_obj->users()->sync($obj['users']);
                  $saved_obj->cameras()->sync($obj['cameras']);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} update group detail {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            } else {
                  $obj['createdby_id'] = $user->id;
                  $saved_obj = $this->model_group->create($obj);
                  $saved_obj->users()->sync($obj['users']);
                  $saved_obj->cameras()->sync($obj['cameras']);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} create new group {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            }

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      public function getById($id)
      {
            return $this->model_group->getModel()::with([
                  'users',
                  'cameras'
            ])->findOrFail($id);
      }

      public function deleteById($id)
      {
            $group = $this->model_group->getModel()::findOrFail($id);
            $obj = [
                  'deletedby_id' => Auth::user()->id
            ];
            $this->model_group->update($obj, $id);
            $group->delete();
            return true;
      }

      //status
      public function updateStatusById($id)
      {
            $group = $this->model_group->getModel()::findOrFail($id);
            $is_active = 1;
            if ($group->is_active == 1) {
                  $is_active = 0;
            }
            $group->is_active = $is_active;
            $group->updatedby_id = Auth::user()->id;
            $group->update();

            return true;
      }
}
