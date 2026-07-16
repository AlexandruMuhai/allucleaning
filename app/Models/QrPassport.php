<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QrPassport extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'location_id',
        'zone_name',
        'next_scheduled_clean',
    ];

    protected $casts = [
        'next_scheduled_clean' => 'datetime',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function cleanLogs(): HasMany
    {
        return $this->hasMany(CleanLog::class);
    }

    public function issueReports(): HasMany
    {
        return $this->hasMany(IssueReport::class);
    }

    public function lastClean(): ?CleanLog
    {
        return $this->cleanLogs()->latest('cleaned_at')->first();
    }
}
