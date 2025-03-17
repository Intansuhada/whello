<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $fillable = ['user_id', 'annual', 'sick'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
