<?php

namespace App\Http\Controllers;

use App\Services\Concrete\CustomerService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class CustomerController extends Controller
{
    use JsonResponse;
    protected $customer_service;
    public function __construct(
        CustomerService  $customer_service
    ) {
        $this->customer_service = $customer_service;
    }

    public function index()
    {
        // abort_if(Gate::denies('customers_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('customers.index');
    }


    public function getData(Request $request)
    {
        // abort_if(Gate::denies('customers_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $this->customer_service->getCustomerSource($request->all());
    }

    public function create()
    {
        // abort_if(Gate::denies('customers_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('customers.create');
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

                return redirect()->back()->withErrors($validator)->withInput();
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

            if (!$customer)
                return redirect()->back()->with('error', config('enum.error'));


            return redirect('customers')->with('success', config('enum.saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function edit($id)
    {
        // abort_if(Gate::denies('customers_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customer = $this->customer_service->getById($id);
        return view('customers.create', compact('customer'));
    }

    public function view($id)
    {
        // abort_if(Gate::denies('customers_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customer = $this->customer_service->getById($id);
        return view('customers.view', compact('customer'));
    }

    // destroy
    public function destroy($id)
    {
        try {
            // abort_if(Gate::denies('customers_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $customer = $this->customer_service->deleteById($id);
            if ($customer)
                return  $this->success(
                    config("enum.delete"),
                    []
                );

            return  $this->error(
                config("enum.error")
            );
        } catch (Exception $e) {
            return  $this->error(
                $e->getMessage()
            );
        }
    }
}
