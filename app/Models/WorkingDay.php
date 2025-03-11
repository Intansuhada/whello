<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    protected $fillable = [
        'day_name',
        'is_working_day',
        'morning_start_time',
        'morning_end_time',
        'afternoon_start_time',
        'afternoon_end_time'
    ];

    protected $casts = [
        'is_working_day' => 'integer'
    ];

    // Remove any default attributes to let database handle defaults

    public function scopeWeekDays($query)
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return $query->whereIn('day_name', $days)->orderByRaw("FIELD(day_name, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')");
    }
}
