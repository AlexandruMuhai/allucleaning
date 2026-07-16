<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'client_id',
        'name',
        'type',
        'address',
        'area_sqm',
        'access_code',
        'cleaning_instructions',
        'schedule_info',
        'is_active',
    ];

    protected $casts = [
        'uuid' => 'string',
        'area_sqm' => 'integer',
        'access_code' => 'encrypted',
        'is_active' => 'boolean',
    ];

    public const TYPE_OFFICE = 'office';
    public const TYPE_STAIRCASE = 'staircase';

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function passports(): HasMany
    {
        return $this->hasMany(QrPassport::class);
    }

    public function cleanLogs(): HasMany
    {
        return $this->hasMany(CleanLog::class);
    }

    public function issueReports(): HasMany
    {
        return $this->hasMany(IssueReport::class);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'location_user')
            ->withTimestamps();
    }

    public function scheduleTemplates(): HasMany
    {
        return $this->hasMany(CleaningScheduleTemplate::class);
    }

    public function cleaningJobs(): HasMany
    {
        return $this->hasMany(CleaningJob::class);
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            self::TYPE_OFFICE => 'Biuro',
            self::TYPE_STAIRCASE => 'Klatka schodowa',
            default => $this->type,
        };
    }
}
