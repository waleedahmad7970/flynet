<?php

use App\Http\Controllers\CameraController;
use App\Http\Controllers\CameraDetectionController;
use App\Http\Controllers\My\MyTestController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cameras', [CameraController::class, 'cameraJson']);
Route::post('/detection/upload', [CameraDetectionController::class, 'screenshotUpload']);
Route::post('/detection/store', [CameraDetectionController::class, 'store']);

