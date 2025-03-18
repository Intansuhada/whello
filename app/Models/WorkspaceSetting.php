<?php
// Model: app/Models/WorkspaceSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkspaceSetting extends Model
{
    use HasFactory;

    protected $table = 'workspace_settings';

    protected $fillable = [
        'workspace_name',
        'photo_profile',
        'description',
        'url_slug',
        'owner_email',
        'team_members',
        'timezone',
        'time_format',
        'date_format',
        'default_language',
        'default_currency',
        'default_hourly_rate',
    ];

    protected $attributes = [
        'timezone' => 'Asia/Jakarta', // Set default timezone
    ];

    public function getTimezoneAttribute($value)
    {
        return $value ?: 'Asia/Jakarta';
    }
}