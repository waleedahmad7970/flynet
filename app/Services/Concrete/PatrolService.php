<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\Patrol;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PatrolService
{
      // initialize protected model variables
      protected $model_patrol;

      public function __construct()
      {
            // set the model
            $this->model_patrol = new Repository(new Patrol);
      }

      public function getPatrolSource($data)
      {
            $model = $this->model_patrol->getModel()::with([
                  'users',
                  'mosaics'
            ]);

            $data = DataTables::of($model)
                  ->addColumn('users', function ($item) {
                        return $item->users ? $item->users->count() : 0;
                  })
                  ->addColumn('mosaics', function ($item) {
                        return $item->mosaics ? $item->mosaics->count() : 0;
                  })
                  ->addColumn('active', function ($item) {
                        $checked = $item->is_active ? 'checked' : '';
                        return "<label class='switch'>
                                <input type='checkbox' class='toggle-status' data-id='{$item->id}' {$checked}>
                                <span class='slider round'></span>
                            </label>";
                  })
                  ->addColumn('action', function ($item) {
                    return view('patrols.inc.actions', compact('item'))->render();
                  })
                  ->rawColumns(['users', 'mosaics', 'active', 'action'])
                  ->make(true);
            return $data;
      }


      public function save($obj)
      {
            $user = Auth::user();
            if ($obj['id'] != null && $obj['id'] != '') {
                  $obj['updatedby_id'] = $user->id;
                  $this->model_patrol->update($obj, $obj['id']);
                  $saved_obj = $this->model_patrol->find($obj['id']);
                  $saved_obj->users()->sync($obj['users']);
                  $saved_obj->mosaics()->sync($obj['mosaics']);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} update patrol detail {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            } else {
                  $obj['createdby_id'] = $user->id;
                  $saved_obj = $this->model_patrol->create($obj);
                  $saved_obj->users()->sync($obj['users']);
                  $saved_obj->mosaics()->sync($obj['mosaics']);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} create new patrol {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            }

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      public function getById($id)
      {
            return $this->model_patrol->getModel()::with([
                  'users',
                  'mosaics'
            ])->findOrFail($id);
      }

      //my patrols
      public function myPatrols()
      {
            return $this->model_patrol->getModel()::with([
                  'users',
                  'mosaics'
            ])
                  ->whereHas('users', function ($query) {
                        $query->where('user_id', auth()->user()->id);
                  })
                  ->where('is_active', 1)
                  ->get();
      }
      public function deleteById($id)
      {
            $patrol = $this->model_patrol->getModel()::findOrFail($id);
            $obj = [
                  'deletedby_id' => Auth::user()->id
            ];
            $this->model_patrol->update($obj, $id);
            $patrol->delete();
            return true;
      }

      //status
      public function updateStatusById($id)
      {
            $patrol = $this->model_patrol->getModel()::findOrFail($id);
            $is_active = 1;
            if ($patrol->is_active == 1) {
                  $is_active = 0;
            }
            $patrol->is_active = $is_active;
            $patrol->updatedby_id = Auth::user()->id;
            $patrol->update();

            return true;
      }
}
