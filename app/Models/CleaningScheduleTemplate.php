<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CleaningScheduleTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'day_of_week',
        'start_time',
        'default_employee_id',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function defaultEmployee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'default_employee_id');
    }

    public function dayOfWeekLabel(): string
    {
        return match ($this->day_of_week) {
            0 => 'Niedziela',
            1 => 'Poniedziałek',
            2 => 'Wtorek',
            3 => 'Środa',
            4 => 'Czwartek',
            5 => 'Piątek',
            6 => 'Sobota',
            default => (string) $this->day_of_week,
        };
    }
}
