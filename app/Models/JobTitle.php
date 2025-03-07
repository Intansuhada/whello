<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobTitle extends Model
{
    use HasFactory;

    protected $table = 'job_titles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'department_id'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
