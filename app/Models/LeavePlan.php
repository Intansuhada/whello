<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeavePlan extends Model
{
    protected $fillable = ['user_id', 'leave_type_id', 'start_date', 'end_date', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
