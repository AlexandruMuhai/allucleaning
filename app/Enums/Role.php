<?php

namespace App\Enums;

enum Role: string
{
    case Administrator = 'administrator';
    case Pracownik = 'pracownik';
    case Klient = 'klient';

    public function label(): string
    {
        return match ($this) {
            self::Administrator => 'Administrator',
            self::Pracownik => 'Pracownik',
            self::Klient => 'Klient',
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::Administrator;
    }
}
