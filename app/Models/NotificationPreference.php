<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    protected $fillable = [
        'user_id',
        'email_task_updates',
        'email_project_updates',
        'email_mentions',
    ];

    protected $casts = [
        'email_task_updates' => 'boolean',
        'email_project_updates' => 'boolean',
        'email_mentions' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
