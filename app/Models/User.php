<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->role_id ??= 2;
            $user->username ??= explode('@', $user->email)[0];
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'role_id',
        'password',
        'avatar_url',  // Pastikan field ini ada
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the role that owns the user.
     */
    public function role() : BelongsTo {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the clients that belong to the user.
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_user');
    }

    /**
     * Get the working hours that belong to the user.
     */
    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }

    /**
     * Get the notification preferences that belong to the user.
     */
    public function notificationPreferences()
    {
        return $this->hasOne(NotificationPreference::class);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->profile && $this->profile->avatar) {
            return Storage::url($this->profile->avatar);
        }
        return asset('images/change-photo.svg');
    }
}
