<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\CustomerService;
use Illuminate\Support\Facades\Validator;

use Exception;

class CustomerController extends Controller
{
    protected $customer_service;

    public function __construct(
        CustomerService  $customer_service
    ) {
        $this->customer_service = $customer_service;
    }

    public function getCustomers()
    {
        $customers = $this->customer_service->allCustomers();

        return response()->json([
            'success' => true,
            'customers' => $customers
        ], 200);
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('customers_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'company' => ['required', 'string'],
                'email' => ['required', 'max:199', 'string', 'unique:customers,email,' . $request->id],
                'document' => ['sometimes', 'file', 'mimes:pdf,xlsx,xls,doc,docx,csv,txt', 'max:5120']
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $obj = [
                "id"            => $request->id,
                "name"          => $request->name,
                "company"       => $request->company,
                "email"         => $request->email
            ];

            if ($request->hasFile('document') && $request->file('document')->isValid()) {
                $file = $request->file('document'); // now it's safe
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/documents'), $filename);
                $obj['file'] = 'uploads/documents/' . $filename;
            }

            $customer = $this->customer_service->save($obj);

            if (!$customer) {
                $validator->errors()->add('error', config('enum.error'));

                return response()->json(['errors' => $validator->errors()], 422);
            }

            return response()->json([
                'success' => true,
                'message' => config('enum.saved'),
                'customer' => $customer,
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

        // destroy
    public function destroy($id)
    {
        try {
            // abort_if(Gate::denies('customers_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $customer = $this->customer_service->deleteById($id);
            if ($customer) {
                return response()->json([
                    'success' => true,
                    'message' => config("enum.delete"),
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => config("enum.error"),
            ], 404);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
