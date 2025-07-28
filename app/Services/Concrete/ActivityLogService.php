<?php

namespace App\Services\Concrete;

use App\Models\ActivityLog;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ActivityLogService
{
      // initialize protected model variables
      protected $model_activity_log;

      public function __construct()
      {
            // set the model
            $this->model_activity_log = new Repository(new ActivityLog());
      }

      public function allActivityLog()
      {
            return $this->model_activity_log->getModel()::orderBy('date', 'desc')
                  ->orderBy('time', 'desc')
                  ->get()
                  ->groupBy('date');
      }
}
