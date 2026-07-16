<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
        ];
    }

    public function isAdministrator(): bool
    {
        return $this->role === Role::Administrator;
    }

    public function isPracownik(): bool
    {
        return $this->role === Role::Pracownik;
    }

    public function isKlient(): bool
    {
        return $this->role === Role::Klient;
    }

    // Aliasy zgodne ze specyfikacją modułu QR
    public function isEmployee(): bool
    {
        return $this->isPracownik();
    }

    public function isClient(): bool
    {
        return $this->isKlient();
    }

    public function roleLabel(): string
    {
        return $this->role?->label() ?? Role::Klient->label();
    }

    public function cleanLogs()
    {
        return $this->hasMany(CleanLog::class);
    }

    public function assignedIssues()
    {
        return $this->hasMany(IssueReport::class, 'assigned_to');
    }

    // Lokalizacje przypisane pracownikowi (pivot location_user)
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_user')->withTimestamps();
    }

    // Lokalizacje będące własnością klienta (client_id = user id)
    public function clientLocations()
    {
        return $this->hasMany(Location::class, 'client_id');
    }

    // Szablony harmonogramu gdzie pracownik jest domyślnym
    public function defaultTemplateJobs()
    {
        return $this->hasMany(CleaningScheduleTemplate::class, 'default_employee_id');
    }

    // Zlecenia przypisane pracownikowi
    public function assignedJobs()
    {
        return $this->hasMany(CleaningJob::class, 'employee_id');
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\AdminResetPassword($token));
    }
}
