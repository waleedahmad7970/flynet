<?php

namespace App\Http\Controllers;

use App\Models\CameraDetection;
use Illuminate\Http\Request;

class CameraDetectionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'camera_id'    => 'required|integer',
            'object_type'  => 'required|string',
            'confidence'   => 'nullable|numeric',
            'detected_at'    => 'required|date',
            'screenshot_path'    => 'nullable|url', // or use image upload endpoint
        ]);

        $detection = CameraDetection::create($validated);

        return response()->json([
            'status' => 'success',
            'detection' => $detection
        ]);
    }

    public function screenshotUpload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $path = $request->file('image')->store('detections', 'public');
        $url = asset('storage/' . $path);

        return response()->json(['screenshot_path' => $url]);
    }
}
