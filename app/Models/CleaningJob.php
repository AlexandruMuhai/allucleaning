<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CleaningJob extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'uuid',
        'location_id',
        'employee_id',
        'scheduled_date',
        'scheduled_time',
        'status',
        'started_at',
        'completed_at',
        'photo_path',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Oczekujące',
            self::STATUS_IN_PROGRESS => 'W toku',
            self::STATUS_COMPLETED => 'Ukończone',
            self::STATUS_CANCELLED => 'Anulowane',
            default => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-slate-100 text-slate-700',
            self::STATUS_IN_PROGRESS => 'bg-amber-50 text-amber-700',
            self::STATUS_COMPLETED => 'bg-emerald-50 text-emerald-700',
            self::STATUS_CANCELLED => 'bg-rose-50 text-rose-600',
            default => 'bg-slate-100 text-slate-700',
        };
    }
}
