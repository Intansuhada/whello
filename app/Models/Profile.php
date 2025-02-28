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
        'full_name',
        'about',
        'department_id',
        'job_title_id'
    ];

    // Tambahkan casting jika diperlukan
    protected $casts = [
        'department_id' => 'integer',
        'job_title_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobTitle(): BelongsTo {
        return $this->belongsTo(JobTitle::class);
    }
}
