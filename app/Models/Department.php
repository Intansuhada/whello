<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description'];

    public function userProfiles(): HasMany
    {
        return $this->hasMany(UserProfile::class);
    }

    public function jobTitles(): HasMany
    {
        return $this->hasMany(JobTitle::class);
    }

    public static function findDepartmentById($id)
    {
        return static::findOrFail($id);
    }
}
