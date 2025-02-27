<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationCode extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'code',
        'expired_at'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
