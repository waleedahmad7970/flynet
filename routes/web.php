<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AlarmController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MosaicController;
use App\Http\Controllers\My\MyAlarmController;
use App\Http\Controllers\My\MyCameraController;
use App\Http\Controllers\My\MyCameraRecordingController;
use App\Http\Controllers\My\MyMosaicController;
use App\Http\Controllers\My\MyPatrolController;
use App\Http\Controllers\PatrolController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'auth/login');
Route::view('dashboard', 'home');
// My
// Route::view('my-cameras', 'my/my_cameras');
// Route::view('my-camera-view', 'my/my_camera_view');

// Route::view('my-patrols', 'my/my_patrols');
// Route::view('my-patrol-view', 'my/my_patrol_view');

// Route::view('my-mosaics', 'my/my_mosaics');
// Route::view('my-mosaic-view', 'my/my_mosaic_view');

// Route::view('my-alarms', 'my/my_alarms');
// Route::view('my-videos', 'my/my_videos');
// Route::view('my-video-view', 'my/my_video_view');


Route::view('list-reports', 'reports/index');

Route::view('access', 'access/index');

Route::view('list-server', 'server/index');


Route::view('list-notification', 'notifications/index');
Route::view('notification/create', 'notifications/create');

Route::view('consumption-calculator', 'consumption/index');

Route::view('address-list', 'address_list/index');

// Route::view('dashboard', 'home');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

      Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
      Route::get('camera-points', [App\Http\Controllers\HomeController::class, 'cameras']);

      Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [PermissionController::class, 'index']);
            Route::post('data', [PermissionController::class, 'getData'])->name('permission.data');
            Route::get('create', [PermissionController::class, 'create']);
            Route::post('store', [PermissionController::class, 'store']);
            Route::get('edit/{id}', [PermissionController::class, 'edit']);
      });

      Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index']);
            Route::post('data', [RoleController::class, 'getData'])->name('role.data');
            Route::get('create', [RoleController::class, 'create']);
            Route::post('store', [RoleController::class, 'store']);
            Route::get('edit/{id}', [RoleController::class, 'edit']);
      });

      Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('data', [UserController::class, 'getData'])->name('user.data');
            Route::get('create', [UserController::class, 'create']);
            Route::post('store', [UserController::class, 'store']);
            Route::get('edit/{id}', [UserController::class, 'edit']);
            // Route::get('destroy/{id}', [UserController::class,'destroy']);
            Route::get('status/{id}', [UserController::class, 'status']);
      });

      // Cameras
      Route::group(['prefix' => 'cameras'], function () {
            Route::get('/', [CameraController::class, 'index']);
            Route::post('data', [CameraController::class, 'getData'])->name('camera.data');
            Route::get('status-counts', [CameraController::class, 'getStatusCount']);
            Route::get('create', [CameraController::class, 'create']);
            Route::post('store', [CameraController::class, 'store']);
            Route::get('edit/{id}', [CameraController::class, 'edit']);
            Route::get('view/{id}', [CameraController::class, 'view']);
            Route::get('destroy/{id}', [CameraController::class, 'destroy']);
            Route::get('status/{id}', [CameraController::class, 'status']);
            Route::get('recording/{id}', [CameraController::class, 'recording'])->name('camera.recording');
            Route::get('download-recording/{id}', [CameraController::class, 'downloadRecording'])->name('camera.downloadRecording');
      });

      // Alarms
      Route::group(['prefix' => 'alarms'], function () {
            Route::get('/', [AlarmController::class, 'index']);
            Route::post('data', [AlarmController::class, 'getData'])->name('alarm.data');
            Route::get('create', [AlarmController::class, 'create']);
            Route::post('store', [AlarmController::class, 'store']);
            Route::get('edit/{id}', [AlarmController::class, 'edit']);
            Route::get('view/{id}', [AlarmController::class, 'view']);
            Route::get('destroy/{id}', [AlarmController::class, 'destroy']);
            Route::get('status/{id}', [AlarmController::class, 'status']);
      });

      // Mosaic
      Route::group(['prefix' => 'mosaics'], function () {
            Route::get('/', [MosaicController::class, 'index']);
            Route::post('data', [MosaicController::class, 'getData'])->name('mosaic.data');
            Route::get('create', [MosaicController::class, 'create']);
            Route::post('store', [MosaicController::class, 'store']);
            Route::get('edit/{id}', [MosaicController::class, 'edit']);
            Route::get('view/{id}', [MosaicController::class, 'view']);
            Route::get('destroy/{id}', [MosaicController::class, 'destroy']);
            Route::get('status/{id}', [MosaicController::class, 'status']);
      });

      // Patrol
      Route::group(['prefix' => 'patrols'], function () {
            Route::get('/', [PatrolController::class, 'index']);
            Route::post('data', [PatrolController::class, 'getData'])->name('patrol.data');
            Route::get('create', [PatrolController::class, 'create']);
            Route::post('store', [PatrolController::class, 'store']);
            Route::get('edit/{id}', [PatrolController::class, 'edit']);
            Route::get('view/{id}', [PatrolController::class, 'view']);
            Route::get('destroy/{id}', [PatrolController::class, 'destroy']);
            Route::get('status/{id}', [PatrolController::class, 'status']);
      });

      // Group
      Route::group(['prefix' => 'groups'], function () {
            Route::get('/', [GroupController::class, 'index']);
            Route::post('data', [GroupController::class, 'getData'])->name('group.data');
            Route::get('create', [GroupController::class, 'create']);
            Route::post('store', [GroupController::class, 'store']);
            Route::get('edit/{id}', [GroupController::class, 'edit']);
            Route::get('view/{id}', [GroupController::class, 'view']);
            Route::get('destroy/{id}', [GroupController::class, 'destroy']);
            Route::get('status/{id}', [GroupController::class, 'status']);
      });

      // Activity log
      Route::get('activity-log', [ActivityLogController::class, 'index']);

      // Customer
      Route::group(['prefix' => 'customers'], function () {
            Route::get('/', [CustomerController::class, 'index']);
            Route::post('data', [CustomerController::class, 'getData'])->name('customer.data');
            Route::get('create', [CustomerController::class, 'create']);
            Route::post('store', [CustomerController::class, 'store']);
            Route::get('edit/{id}', [CustomerController::class, 'edit']);
            Route::get('destroy/{id}', [CustomerController::class, 'destroy']);
      });

      // My cameras
      Route::get('my-cameras', [MyCameraController::class, 'index'])->name('my-cameras.index');
      Route::get('my-cameras/view/{id}', [MyCameraController::class, 'view'])->name('my-cameras.view');

      // My Mosaics
      Route::get('my-mosaics', [MyMosaicController::class, 'index'])->name('my-mosaics.index');
      Route::get('my-mosaics/view/{id}', [MyMosaicController::class, 'view'])->name('my-mosaics.view');

      // My patrols
      Route::get('my-patrols', [MyPatrolController::class, 'index'])->name('my-patrols.index');
      Route::get('my-patrols/view/{id}', [MyPatrolController::class, 'view'])->name('my-patrols.view');

      // My alarms
      Route::get('my-alarms', [MyAlarmController::class, 'index'])->name('my-alarms.index');

      // My videos
      Route::get('my-videos', [MyCameraRecordingController::class, 'index'])->name('my-videos.index');
      Route::get('my-videos/view/{id}', [MyCameraRecordingController::class, 'view'])->name('my-videos.view');
});
