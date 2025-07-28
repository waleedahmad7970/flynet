<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camera extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'slug',
        'name',
        'ip_address',
        'protocol',
        'manufacturer',
        'stream_url',
        'username',
        'password',
        'port',
        'location',
        'longitude',
        'latitude',
        'is_active',
        'status',

        'createdby_id',
        'updatedby_id',
        'deletedby_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function alarms()
    {
        return $this->belongsToMany(Alarm::class);
    }

    public function mosaics()
    {
        return $this->belongsToMany(Mosaic::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function recordings()
    {
        return $this->hasMany(CameraRecording::class);
    }
}
