<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InactivatedAccount extends Model
{
    protected $table = 'inactivated_user_accounts';
    
    protected $fillable = [
        'id',
        'email',
        'token',
        'role',
        'expires_at'
    ];

    protected $dates = [
        'expires_at'
    ];

    public $timestamps = true;
}
