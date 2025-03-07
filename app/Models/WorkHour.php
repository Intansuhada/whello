<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkHour extends Model
{
    protected $table = 'work_hours';
    
    protected $fillable = [
        'user_id',
        'day',
        'morning_start',
        'morning_end',
        'afternoon_start',
        'afternoon_end',
        'is_active',
        'type'
    ];

    // Cast time fields to proper format
    protected $casts = [
        'morning_start' => 'datetime:H:i',
        'morning_end' => 'datetime:H:i',
        'afternoon_start' => 'datetime:H:i',
        'afternoon_end' => 'datetime:H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
