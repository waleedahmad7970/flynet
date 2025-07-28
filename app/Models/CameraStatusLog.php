<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CameraStatusLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'camera_id',
        'status',
        'checked_at'
    ];

    public function getCheckedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
