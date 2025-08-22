<?php

namespace App\Services\Concrete;

use App\Repository\Repository;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
// use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\File;
// use Symfony\Component\Process\Process;
// use Symfony\Component\Process\Exception\ProcessFailedException;

class NotificationService
{
    // initialize protected model variables
    protected $model_notification;

    public function __construct()
    {
        // set the model
        $this->model_notification = new Repository(new Notification);
    }

    public function save($obj)
    {
        $user = Auth::user();
        if ($obj['id'] != null && $obj['id'] != '') {
            dd($obj);
            $this->model_notification->update($obj, $obj['id']);
            $saved_obj = $this->model_notification->find($obj['id']);

            $time = now()->format('h:i A');
            $message = "$time • {$user->name} update notification detail {$saved_obj->id} - {$saved_obj->title} in the Admin Panel.";
            newActivity($message);
        } else {

            $saved_obj = $this->model_notification->create($obj);

            $time = now()->format('h:i A');
            $message = "$time • {$user->name} create new notification {$saved_obj->id} - {$saved_obj->title} in the Admin Panel.";
            newActivity($message);
        }

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    public function myNotifications()
    {
        return $this->model_notification->getModel()::with('users')
                    ->whereHas('users', function ($query) {
                        $query->where('receiver_id', auth()->user()->id);
                    })
                    ->where('status', 'open')
                    ->get();
    }
}
