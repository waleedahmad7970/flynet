<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

use Carbon\Carbon;

class ReportService
{
    // initialize protected model variables
    protected $model_report;

    public function __construct()
    {
        // set the model
        $this->model_report = new Repository(new Report);
    }

    public function getReportSource()
    {
        $model = Report::with('user');
        $data = DataTables::of($model)
            ->editColumn('type', function ($row) {
                return ucwords($row->type);
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->toDayDateTimeString();
            })
            ->addColumn('action', function ($item) {
                return view('reports.inc.actions', compact('item'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
        return $data;
    }

    public function save($obj)
    {
        $user = Auth::user();
        if ($obj['id'] != null && $obj['id'] != '') {
            $this->model_report->update($obj, $obj['id']);
            $saved_obj = $this->model_report->find($obj['id']);

            $time = now()->format('h:i A');
            $message = "$time • {$user->name} update report details {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
            newActivity($message);
        } else {
            $saved_obj = $this->model_report->create($obj);

            $time = now()->format('h:i A');
            $message = "$time • {$user->name} create new repprt {$saved_obj->id} - {$saved_obj->name} in the Admin Panel.";
            newActivity($message);
        }

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    public function getById($id)
    {
        return $this->model_report->getModel()::find($id);
    }
}
