<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'service_type',
        'message',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public static function serviceTypes(): array
    {
        return [
            'biuro' => 'Sprzątanie Biur',
            'lokal' => 'Lokale Usługowe i Handlowe',
            'klatka' => 'Klatki Schodowe i Wspólnoty',
            'inne' => 'Inne',
        ];
    }

    public function getServiceTypeLabelAttribute(): string
    {
        return self::serviceTypes()[$this->service_type] ?? $this->service_type;
    }
}
