<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CleanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'qr_passport_id',
        'user_id',
        'cleaned_at',
        'photo_path',
        'notes',
    ];

    protected $casts = [
        'cleaned_at' => 'datetime',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function passport(): BelongsTo
    {
        return $this->belongsTo(QrPassport::class, 'qr_passport_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
