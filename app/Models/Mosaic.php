<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mosaic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'no_of_cameras',
        'is_active',
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

    public function patrols()
    {
        return $this->belongsToMany(Patrol::class);
    }
}
