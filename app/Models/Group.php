<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'comment',
        'default',
        'external_default',
        'is_active',
        'panic_alert',
        'view_recording',
        'enable_chat',
        'panic_notification',
        'analytical_notification',
        'offline_notification',
        'createdby_id',
        'updatedby_id',
        'deletedby_id'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function cameras()
    {
        return $this->belongsToMany(Camera::class);
    }
}
