<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CameraController;
use App\Http\Controllers\Api\AlarmController;
use App\Http\Controllers\Api\MosaicController;
use App\Http\Controllers\Api\PatrolController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\My\MyCameraController;
use App\Http\Controllers\Api\My\MyMosaicController;
use App\Http\Controllers\Api\My\MyPatrolController;
use App\Http\Controllers\Api\My\MyAlarmController;
use App\Http\Controllers\Api\My\MyCameraRecordingController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [LoginController::class, 'logout']);
    Route::get('dashboard', [HomeController::class, 'index']);

    // Permissions
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'getPermissions']);
        Route::post('store', [PermissionController::class, 'store']);
    });

    // Roles
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'getRoles']);
        Route::post('store', [RoleController::class, 'store']);
    });

    // Users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'getUsers']);
        Route::post('store', [UserController::class, 'store']);
        Route::put('/{id}/update', [UserController::class, 'update']);
        Route::post('password', [UserController::class, 'updatePassword']);
    });

    // Cameras
    Route::group(['prefix' => 'cameras'], function () {
        Route::get('/', [CameraController::class, 'getCameras']);
        Route::post('store', [CameraController::class, 'store']);
        Route::get('view/{id}', [CameraController::class, 'view']);
        Route::get('destroy/{id}', [CameraController::class, 'destroy']);
        Route::get('status/{id}', [CameraController::class, 'status']);
        Route::get('recording/{id}', [CameraController::class, 'recording']);
        Route::get('download-recording/{id}', [CameraController::class, 'downloadRecording']);
    });

    // Alarms
    Route::group(['prefix' => 'alarms'], function () {
        Route::get('/', [AlarmController::class, 'getAlarms']);
        Route::post('store', [AlarmController::class, 'store']);
        Route::get('view/{id}', [AlarmController::class, 'view']);
        Route::get('destroy/{id}', [AlarmController::class, 'destroy']);
        Route::get('status/{id}', [AlarmController::class, 'status']);
    });

    // Mosaics
    Route::group(['prefix' => 'mosaics'], function () {
        Route::get('/', [MosaicController::class, 'getMosaics']);
        Route::post('store', [MosaicController::class, 'store']);
        Route::get('view/{id}', [MosaicController::class, 'view']);
        Route::get('destroy/{id}', [MosaicController::class, 'destroy']);
        Route::get('status/{id}', [MosaicController::class, 'status']);
    });

    // Patrol
    Route::group(['prefix' => 'patrols'], function () {
        Route::get('/', [PatrolController::class, 'getPatrols']);
        Route::post('store', [PatrolController::class, 'store']);
        Route::get('view/{id}', [PatrolController::class, 'view']);
        Route::get('destroy/{id}', [PatrolController::class, 'destroy']);
        Route::get('status/{id}', [PatrolController::class, 'status']);
    });

        // Group
    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', [GroupController::class, 'getGroups']);
        Route::post('store', [GroupController::class, 'store']);
        Route::get('view/{id}', [GroupController::class, 'view']);
        Route::get('destroy/{id}', [GroupController::class, 'destroy']);
        Route::get('status/{id}', [GroupController::class, 'status']);
    });

    // Activity log
    Route::get('activity-logs', [ActivityLogController::class, 'getActivityLogs']);
    Route::post('activity-log-filter', [ActivityLogController::class, 'filterActivityLogs']);

    // Customer
    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', [CustomerController::class, 'getCustomers']);
        Route::post('store', [CustomerController::class, 'store']);
        Route::get('destroy/{id}', [CustomerController::class, 'destroy']);
    });

    // Notifications
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', [NotificationController::class, 'getNotifications']);
        Route::post('store', [NotificationController::class, 'store']);
    });

    Route::get('server', [ServerController::class, 'getServerDetails']);

    // Reports
    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', [ReportController::class, 'getReports']);
        Route::post('users/csv', [ReportController::class, 'usersCSV']);
        Route::post('cameras/csv', [ReportController::class, 'camerasCSV']);
        Route::get('/{id}/download', [ReportController::class, 'download']);
        Route::delete('/{id}', [ReportController::class, 'destroy']);
    });

    // My cameras
    Route::get('my-cameras', [MyCameraController::class, 'getMyCameras']);
    Route::get('my-cameras/view/{id}', [MyCameraController::class, 'view']);
    Route::get('my-cameras/filter_minutes', [MyCameraController::class, 'filter_minutes']);

    // My Mosaics
    Route::get('my-mosaics', [MyMosaicController::class, 'getMyMosaics']);
    Route::get('my-mosaics/view/{id}', [MyMosaicController::class, 'view']);

    // My patrols
    Route::get('my-patrols', [MyPatrolController::class, 'getMyPatrols']);
    Route::get('my-patrols/view/{id}', [MyPatrolController::class, 'view']);

    // My alarms
    Route::get('my-alarms', [MyAlarmController::class, 'getMyAlarms']);

    // My videos
    Route::get('my-videos', [MyCameraRecordingController::class, 'getMyVideos']);
    Route::get('my-videos/view/{id}', [MyCameraRecordingController::class, 'view']);

});


