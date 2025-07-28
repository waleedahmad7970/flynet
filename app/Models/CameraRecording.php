<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CameraRecording extends Model
{
    use HasFactory;
    protected $fillable = [
        'camera_id',
        'file_name',
        'file_path',
        'start_time',
        'end_time',
        'recording_type',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];
    

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function camera(){
        return $this->belongsTo(Camera::class);
    }

}
