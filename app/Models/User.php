<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

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
        'activation_token',
        'email_verified_at',
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
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function getDepartmentAttribute()
    {
        return $this->profile?->department;
    }

    public function getJobTitleAttribute()
    {
        return $this->profile?->jobTitle;
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

    public function leavePlans()
    {
        return $this->hasMany(LeavePlan::class);
    }
}
