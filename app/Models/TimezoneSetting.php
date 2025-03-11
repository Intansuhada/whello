<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimezoneSetting extends Model
{
    protected $fillable = [
        'timezone',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get the active timezone setting
     */
    public static function getActiveTimezone()
    {
        return static::where('is_active', true)->first()?->timezone ?? config('app.timezone');
    }

    /**
     * Set the active timezone
     */
    public static function setActiveTimezone($timezone)
    {
        // Deactivate all existing timezones
        static::query()->update(['is_active' => false]);
        
        // Try to find existing timezone or create new one
        $timezoneSetting = static::firstOrNew(['timezone' => $timezone]);
        $timezoneSetting->is_active = true;
        $timezoneSetting->save();
        
        return $timezoneSetting;
    }
}
