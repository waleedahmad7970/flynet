<?php

namespace App\Services\Concrete;

use App\Models\Customer;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CustomerService
{
      // initialize protected model variables
      protected $model_customer;

      public function __construct()
      {
            // set the model
            $this->model_customer = new Repository(new Customer());
      }

      public function getCustomerSource($data)
      {
            $model = $this->model_customer->getModel()::query();

            $data = DataTables::of($model)
                  ->addColumn('action', function ($item) {
                    return view('customers.inc.actions', compact('item'))->render();
                  })
                  ->rawColumns(['action'])
                  ->make(true);
            return $data;
      }
      public function allActiveCustomer()
      {
            return $this->model_customer->getModel()::get();
      }

      public function save($obj)
      {
            $user = Auth::user();
            if ($obj['id'] != null && $obj['id'] != '') {
                  $obj['updatedby_id'] = $user->id;
                  $this->model_customer->update($obj, $obj['id']);
                  $saved_obj = $this->model_customer->find($obj['id']);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} update customer detail {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            } else {
                  $obj['createdby_id'] = $user->id;
                  $saved_obj = $this->model_customer->create($obj);

                  $time = now()->format('h:i A');
                  $message = "$time • {$user->name} create new customer {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
                  newActivity($message);
            }

            if (!$saved_obj)
                  return false;

            return $saved_obj;
      }

      public function getById($id)
      {
            return $this->model_customer->getModel()::findOrFail($id);
      }

      public function deleteById($id)
      {
            $customer = $this->model_customer->getModel()::findOrFail($id);
            $obj = [
                  'deletedby_id' => Auth::user()->id
            ];
            $this->model_customer->update($obj, $id);
            $customer->delete();
            return true;
      }
}
