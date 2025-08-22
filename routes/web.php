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
use App\Http\Controllers\ServerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CalculatorController;
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


// Route::view('list-reports', 'reports/index');


// Route::view('list-server', 'server/index');


// Route::view('list-notification', 'notifications/index');
// Route::view('notification/create', 'notifications/create');

// Route::view('address-list', 'address_list/index');

// Route::view('dashboard', 'home');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('camera-points', [App\Http\Controllers\HomeController::class, 'cameras']);

    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('data', [PermissionController::class, 'getData'])->name('permission.data');
        Route::get('create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('store', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::post('data', [RoleController::class, 'getData'])->name('role.data');
        Route::get('create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('data', [UserController::class, 'getData'])->name('user.data');
        Route::get('create', [UserController::class, 'create'])->name('users.create');
        Route::post('store', [UserController::class, 'store'])->name('users.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('edit/{id}', [UserController::class, 'update'])->name('users.update');
        // Route::get('destroy/{id}', [UserController::class,'destroy'])->name('users.destroy');
        Route::get('status/{id}', [UserController::class, 'status'])->name('users.status');
        Route::get('password', [UserController::class, 'editPassword'])->name('users.password.edit');
        Route::post('password', [UserController::class, 'updatePassword'])->name('admin.password.update');
    });

    // Cameras
    Route::group(['prefix' => 'cameras'], function () {
        Route::get('/', [CameraController::class, 'index'])->name('cameras.index');
        Route::post('data', [CameraController::class, 'getData'])->name('camera.data');
        Route::get('status-counts', [CameraController::class, 'getStatusCount']);
        Route::get('create', [CameraController::class, 'create'])->name('cameras.create');
        Route::post('store', [CameraController::class, 'store'])->name('cameras.store');
        Route::get('edit/{id}', [CameraController::class, 'edit'])->name('cameras.edit');
        Route::get('view/{id}', [CameraController::class, 'view']) ->name('cameras.show');
        Route::get('destroy/{id}', [CameraController::class, 'destroy'])->name('cameras.destory');
        Route::get('status/{id}', [CameraController::class, 'status']);
        Route::get('recording/{id}', [CameraController::class, 'recording'])->name('camera.recording');
        Route::get('download-recording/{id}', [CameraController::class, 'downloadRecording'])->name('camera.downloadRecording');
    });

    // Alarms
    Route::group(['prefix' => 'alarms'], function () {
        Route::get('/', [AlarmController::class, 'index'])->name('alarms.index');
        Route::post('data', [AlarmController::class, 'getData'])->name('alarm.data');
        Route::get('create', [AlarmController::class, 'create'])->name('alarms.create');
        Route::post('store', [AlarmController::class, 'store'])->name('alarms.store');
        Route::get('edit/{id}', [AlarmController::class, 'edit'])->name('alarms.edit');
        Route::get('view/{id}', [AlarmController::class, 'view'])->name('alarms.show');
        Route::get('destroy/{id}', [AlarmController::class, 'destroy'])->name('alarms.destroy');
        Route::get('status/{id}', [AlarmController::class, 'status'])->name('alarms.status');
    });

    // Mosaic
    Route::group(['prefix' => 'mosaics'], function () {
        Route::get('/', [MosaicController::class, 'index'])->name('mosaics.index');
        Route::post('data', [MosaicController::class, 'getData'])->name('mosaic.data');
        Route::get('create', [MosaicController::class, 'create'])->name('mosaics.create');
        Route::post('store', [MosaicController::class, 'store'])->name('mosaics.store');
        Route::get('edit/{id}', [MosaicController::class, 'edit'])->name('mosaics.edit');
        Route::get('view/{id}', [MosaicController::class, 'view'])->name('mosaics.show');
        Route::get('destroy/{id}', [MosaicController::class, 'destroy'])->name('mosaics.destroy');
        Route::get('status/{id}', [MosaicController::class, 'status'])->name('mosaics.status');
    });

    // Patrol
    Route::group(['prefix' => 'patrols'], function () {
        Route::get('/', [PatrolController::class, 'index'])->name('patrols.index');
        Route::post('data', [PatrolController::class, 'getData'])->name('patrol.data');
        Route::get('create', [PatrolController::class, 'create'])->name('patrols.create');
        Route::post('store', [PatrolController::class, 'store'])->name('patrols.store');
        Route::get('edit/{id}', [PatrolController::class, 'edit'])->name('patrols.edit');
        Route::get('view/{id}', [PatrolController::class, 'view'])->name('patrols.show');
        Route::get('destroy/{id}', [PatrolController::class, 'destroy'])->name('patrols.destroy');
        Route::get('status/{id}', [PatrolController::class, 'status'])->name('patrols.status');
    });

    // Group
    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', [GroupController::class, 'index'])->name('groups.index');
        Route::post('data', [GroupController::class, 'getData'])->name('group.data');
        Route::get('create', [GroupController::class, 'create'])->name('groups.create');
        Route::post('store', [GroupController::class, 'store'])->name('groups.store');
        Route::get('edit/{id}', [GroupController::class, 'edit'])->name('groups.edit');
        Route::get('view/{id}', [GroupController::class, 'view'])->name('groups.show');
        Route::get('destroy/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');
        Route::get('status/{id}', [GroupController::class, 'status'])->name('groups.status');
    });

    // Activity log
    Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::post('activity-log-filter', [ActivityLogController::class, 'filter_index'])->name('activity-log-filter');

    // Customer
    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('data', [CustomerController::class, 'getData'])->name('customer.data');
        Route::get('create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('store', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::get('destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    // My cameras
    Route::get('my-cameras', [MyCameraController::class, 'index'])->name('my-cameras.index');
    Route::get('my-cameras/view/{id}', [MyCameraController::class, 'view'])->name('my-cameras.view');
    Route::get('my-cameras/filter_minutes', [MyCameraController::class, 'filter_minutes'])->name('my-cameras.filter_minutes');

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

    Route::get('server', [ServerController::class, 'index'])->name('server.index');

    // Notifications
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('store', [NotificationController::class, 'store'])->name('notifications.store');
    });

    Route::get('addresses', [AddressController::class, 'index'])->name('addresses.index');

    Route::get('consumption-calculator', [CalculatorController::class, 'index'])->name('calculator.index');

    // Notifications
    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::post('data', [ReportController::class, 'getData']);
        Route::post('users/csv', [ReportController::class, 'usersCSV'])->name('reports.users.csv');
        Route::post('cameras/csv', [ReportController::class, 'camerasCSV'])->name('reports.cameras.csv');
        Route::get('/{id}/download', [ReportController::class, 'download'])->name('reports.download');
        Route::delete('/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
    });

    Route::view('access', 'access/index');

});
