<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

if (!function_exists('newActivity')) {
      function newActivity($message) {
            $time = now()->format('h:i:s');
            $date = now()->format('Y-m-d');
            $user = Auth::user();

            $activity = new ActivityLog();
            $activity->time = $time;
            $activity->date = $date;
            $activity->description = $message;
            $activity->createdby_id = $user->id;
            $activity->save();
      }
}
