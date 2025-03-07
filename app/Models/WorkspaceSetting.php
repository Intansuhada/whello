<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkspaceSetting extends Model
{
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
        'default_hourly_rate'
    ];
}
