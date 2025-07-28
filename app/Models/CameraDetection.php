<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CameraDetection extends Model
{
    use HasFactory;
    protected $fillable = [
        'camera_id',
        'confidence',
        'object_type',
        'detected_at',
        'screenshot_path'
    ];

    public function getDetectedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
