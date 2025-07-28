<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\Mosaic;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class MosaicService
{
      // initialize protected model variables
      protected $model_mosaic;

      public function __construct()
      {
            // set the model
            $this->model_mosaic = new Repository(new Mosaic);
      }

      public function getMosaicSource($data)
      {
            $model = $this->model_mosaic->getModel()::with([
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
                        $edit_column    = "<a class='btn btn-warning btn-sm mr-2' href='mosaics/edit/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                        // $view_column    = "<a class='btn btn-info btn-sm mr-2' href='mosaics/view/" . $item->id . "'><i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View</a>";
                        $delete_column = "<button class='btn btn-danger btn-sm delete-mosaic' data-id='{$item->id}'><i class='fa fa-trash'></i> Delete</button>";
                        // if(Auth::user()->can('mosaics_edit'))
                        $action_column .= $edit_column;

                        // if(Auth::user()->can('mosaics_view'))
                        // $action_column .= $view_column;

                        // if(Auth::user()->can('mosaics_delete'))
                        $action_column .= $delete_column;


                        return $action_column;
                  })
                  ->rawColumns(['active', 'action'])
                  ->make(true);
            return $data;
      }
      public function allActiveMosaic()
      {
            return $this->model_mosaic->getModel()::where('is_active', 1)->get();
      }

      public function save($obj)
      {
            $user = Auth::user();
            if ($obj['id'] != null && $obj['id'] != '') {
                  $obj['updatedby_id'] = $user->id;
                  $this->model_mosaic->update($obj, $obj['id']);
                  $saved_obj = $this->model_mosaic->find($obj['id']);
                  $saved_obj->users()->sync($obj['users']);
                  $saved_obj->cameras()->sync($obj['cameras']);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} update mosaic detail {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            } else {
                  $obj['createdby_id'] = $user->id;
                  $saved_obj = $this->model_mosaic->create($obj);
                  $saved_obj->users()->sync($obj['users']);
                  $saved_obj->cameras()->sync($obj['cameras']);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} create new mosaic {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            }

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      public function getById($id)
      {
            return $this->model_mosaic->getModel()::with([
                  'users',
                  'cameras'
            ])->findOrFail($id);
      }

      //my mosaics
      public function myMosaics()
      {
            return $this->model_mosaic->getModel()::with([
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
            $mosaic = $this->model_mosaic->getModel()::findOrFail($id);
            $obj = [
                  'deletedby_id' => Auth::user()->id
            ];
            $this->model_mosaic->update($obj, $id);
            $mosaic->delete();
            return true;
      }

      //status
      public function updateStatusById($id)
      {
            $mosaic = $this->model_mosaic->getModel()::findOrFail($id);
            $is_active = 1;
            if ($mosaic->is_active == 1) {
                  $is_active = 0;
            }
            $mosaic->is_active = $is_active;
            $mosaic->updatedby_id = Auth::user()->id;
            $mosaic->update();

            return true;
      }
}
