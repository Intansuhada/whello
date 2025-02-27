<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $table = 'user_profiles';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::boot();        

        static::creating(function ($profile) {
            $profile->nickname ??= implode(' ', array_filter(explode('@', $profile->name)));
            $profile->job_title_id ??= 1;
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nickname',
        'name',
        'avatar',
        'about',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function jobTitle(): BelongsTo {
        return $this->belongsTo(JobTitle::class);
    }
}
