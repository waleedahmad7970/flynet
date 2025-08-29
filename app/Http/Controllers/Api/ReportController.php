<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Concrete\ReportService;
use App\Services\Concrete\UserService;
use Illuminate\Support\Facades\Storage;
use App\Services\Concrete\CameraService;

use Carbon\Carbon;
use Exception;

class ReportController extends Controller
{
    // initialize protected model variables
    protected $user_service;
    protected $report_service;
    protected $camera_service;

    public function __construct(
        UserService  $user_service,
        ReportService $report_service,
        CameraService $camera_service
    ) {
        $this->user_service = $user_service;
        $this->report_service = $report_service;
        $this->camera_service = $camera_service;
    }

    public function getReports()
    {
        $reports = $this->report_service->getAllReports();

        return response()->json([
            'success' => true,
            'reports' => $reports
        ], 200);
    }

    public function usersCSV(Request $request)
    {
        $fileName = 'users_report_' . now()->format('Ymd_His') . '.csv';
        $filePath = 'reports/' . $fileName;

        // Create directory if not exists
        Storage::makeDirectory('reports');

         // Open CSV file for writing in storage
        $handle = fopen(storage_path('app/' . $filePath), 'w');

        $columns = ['ID', 'Name', 'Email', 'Phone', 'Created At'];

        // Add headers
        fputcsv($handle, $columns);

        $users = $this->user_service->getAllUsers();

        foreach ($users as $user) {
            fputcsv($handle, [
                $user->id,
                $user->name,
                $user->email,
                $user->phone,
                Carbon::parse($user->created_at)->format('d-m-Y H:i'),
            ]);
        }

        fclose($handle);

        $obj = [
            'id'             => $request->id,
            "type"           => 'users',
            "description"    => $request->description,
            "file_path"      => $filePath,
            "format"         => 'csv',
            "generated_by"   => auth('sanctum')->user()->id,
        ];

        $this->report_service->save($obj);

        return response()->json([
            'success' => true,
            'message' => 'Users report generated successfully!'
        ], 200);
    }

    public function camerasCSV(Request $request)
    {
        $fileName = 'cameras_report_' . now()->format('Ymd_His') . '.csv';
        $filePath = 'reports/' . $fileName;

        // Create directory if not exists
        Storage::makeDirectory('reports');

         // Open CSV file for writing in storage
        $handle = fopen(storage_path('app/' . $filePath), 'w');

        $columns = ['ID', 'Name', 'Protocol', 'Stream Url', 'Location', 'Created At'];

        // Add headers
        fputcsv($handle, $columns);

        $cameras = $this->camera_service->getAllCameras();

        foreach ($cameras as $camera) {
            fputcsv($handle, [
                $camera->id,
                $camera->name,
                $camera->protocol,
                $camera->stream_url,
                $camera->location,
                Carbon::parse($camera->created_at)->format('d-m-Y H:i'),
            ]);
        }

        fclose($handle);

        $obj = [
            'id'             => $request->id,
            "type"           => 'cameras',
            "description"    => $request->description,
            "file_path"      => $filePath,
            "format"         => 'csv',
            "generated_by"   => auth('sanctum')->user()->id,
        ];

        $this->report_service->save($obj);

        return response()->json([
            'success' => true,
            'message' => 'Cameras report generated successfully!'
        ], 200);
    }

    public function download($id)
    {
        $report = $this->report_service->getById($id);

        if (!Storage::exists($report->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found!'
            ], 404);
        }

        // Extract the filename from file_path
        $filename = basename($report->file_path);

        return Storage::download($report->file_path, $filename);
    }

    public function destroy($id)
    {
        try {
            $report = $this->report_service->getById($id);

            // Delete file from storage (check if exists)
            if (Storage::exists($report->file_path)) {
                Storage::delete($report->file_path);
            }

            // Delete DB record
            $report->delete();

            return response()->json([
                'success' => true,
                'message' => config("enum.delete"),
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
