<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => fake()->randomElement(array_column(Role::cases(), 'value')),
        ];
    }

    public function administrator(): static
    {
        return $this->state(fn () => ['role' => Role::Administrator->value]);
    }

    public function pracownik(): static
    {
        return $this->state(fn () => ['role' => Role::Pracownik->value]);
    }

    public function klient(): static
    {
        return $this->state(fn () => ['role' => Role::Klient->value]);
    }
}
