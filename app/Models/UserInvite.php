<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvite extends Model
{
    protected $fillable = [
        'invite_email',
        'token',
        'expires_at'
    ];

    protected $dates = [
        'expires_at',
    ];
}
