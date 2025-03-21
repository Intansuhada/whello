<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function jobTitles() {
        return $this->hasMany(JobTitle::class);
    }
}
