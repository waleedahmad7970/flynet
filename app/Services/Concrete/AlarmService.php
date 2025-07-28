<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\Alarm;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AlarmService
{
      // initialize protected model variables
      protected $model_alarm;

      public function __construct()
      {
            // set the model
            $this->model_alarm = new Repository(new Alarm);
      }

      public function getAlarmSource($data)
      {
            $model = $this->model_alarm->getModel()::with([
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
                  ->addColumn('active', function ($item) {
                        $checked = $item->is_active ? 'checked' : '';
                        return "<label class='switch'>
                                <input type='checkbox' class='toggle-status' data-id='{$item->id}' {$checked}>
                                <span class='slider round'></span>
                            </label>";
                  })
                  ->addColumn('action', function ($item) {
                        $action_column = '';
                        $edit_column    = "<a class='btn btn-warning btn-sm mr-2' href='alarms/edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                        $view_column    = "<a class='btn btn-info btn-sm mr-2' href='alarms/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                        $delete_column = "<button class='btn btn-danger btn-sm delete-alarm' data-id='{$item->id}'><i class='fa fa-trash'></i> Delete</button>";
                        // if(Auth::user()->can('alarms_edit'))
                        $action_column .= $edit_column;

                        // if(Auth::user()->can('alarms_view'))
                        $action_column .= $view_column;

                        // if(Auth::user()->can('alarms_delete'))
                        $action_column .= $delete_column;


                        return $action_column;
                  })
                  ->rawColumns(['active', 'action'])
                  ->make(true);
            return $data;
      }


      public function save($obj)
      {
            $user = Auth::user();
            if ($obj['id'] != null && $obj['id'] != '') {
                  $obj['updatedby_id'] = $user->id;
                  $this->model_alarm->update($obj, $obj['id']);
                  $saved_obj = $this->model_alarm->find($obj['id']);
                  $saved_obj->users()->sync($obj['users']);
                  $saved_obj->cameras()->sync($obj['cameras']);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} update alarm detail {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            } else {
                  $obj['createdby_id'] = $user->id;
                  $saved_obj = $this->model_alarm->create($obj);
                  $saved_obj->users()->sync($obj['users']);
                  $saved_obj->cameras()->sync($obj['cameras']);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} create new alarm {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            }

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      public function getById($id)
      {
            return $this->model_alarm->getModel()::with([
                  'users',
                  'cameras'
            ])->findOrFail($id);
      }

      // my alarms
      public function myAlarms()
      {
            return $this->model_alarm->getModel()::with([
                  'users',
                  'cameras'
            ])
                  ->whereHas('users', function ($query) {
                        $query->where('user_id', auth()->user()->id);
                  })
                  ->where('is_active', 1)
                  ->get();
      }

      public function deleteById($id)
      {
            $alarm = $this->model_alarm->getModel()::findOrFail($id);
            $obj = [
                  'deletedby_id' => Auth::user()->id
            ];
            $this->model_alarm->update($obj, $id);
            $alarm->delete();
            return true;
      }

      //status
      public function updateStatusById($id)
      {
            $alarm = $this->model_alarm->getModel()::findOrFail($id);
            $is_active = 1;
            if ($alarm->is_active == 1) {
                  $is_active = 0;
            }
            $alarm->is_active = $is_active;
            $alarm->updatedby_id = Auth::user()->id;
            $alarm->update();

            return true;
      }
}
