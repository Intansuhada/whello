<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $fillable = [
        'user_id',
        'day',
        'morning_start',
        'morning_end',
        'afternoon_start',
        'afternoon_end',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
