<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = ['name', 'code', 'description'];

    public function leavePlans()
    {
        return $this->hasMany(LeavePlan::class);
    }
}
