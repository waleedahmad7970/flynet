<?php

namespace App\Services\Concrete;

use App\Models\Camera;
use App\Models\CameraRecording;
use App\Models\Group;
use App\Models\Mosaic;
use App\Models\Patrol;
use App\Repository\Repository;
use App\Models\User;

class HomeService
{
      // initialize protected model variables
      protected $model_users;
      protected $model_cameras;
      protected $model_mosaics;
      protected $model_groups;
      protected $model_patrols;
      protected $model_videos;

      public function __construct()
      {
            // set the model
            $this->model_users = new Repository(new User());
            $this->model_cameras = new Repository(new Camera());
            $this->model_mosaics = new Repository(new Mosaic());
            $this->model_groups = new Repository(new Group());
            $this->model_patrols = new Repository(new Patrol());
            $this->model_videos = new Repository(new CameraRecording());
      }

      public function dasboard()
      {
            $users = $this->model_users->getModel()::count();
            $cameras = $this->model_cameras->getModel()::count();
            $mosaics = $this->model_mosaics->getModel()::count();
            $groups = $this->model_groups->getModel()::count();
            $patrols = $this->model_patrols->getModel()::count();
            $videos = $this->model_videos->getModel()::count();
            return [
                  "users" => $users,
                  "cameras" => $cameras,
                  "mosaics" => $mosaics,
                  "groups" => $groups,
                  "patrols" => $patrols,
                  "videos" => $videos
            ];
      }

      public function cameras()
      {
            $cameras = $this->model_cameras->getModel()::select('id', 'name', 'ip_address', 'latitude', 'longitude')->get();

            $formatted = $cameras->map(function ($cam) {
                  return [
                        'id' => $cam->id,
                        'latitude' => (float) $cam->latitude,
                        'longitude' => (float) $cam->longitude,
                        'name' => $cam->name,
                        'ip' => $cam->ip_address,
                        'radius' => 6,
                        'fillKey' => 'camera'
                  ];
            });
            return $formatted;
      }
}
