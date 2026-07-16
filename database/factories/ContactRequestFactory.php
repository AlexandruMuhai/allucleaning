<?php

namespace Database\Factories;

use App\Models\ContactRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactRequestFactory extends Factory
{
    protected $model = ContactRequest::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('pl_PL');
        $serviceTypes = array_keys(ContactRequest::serviceTypes());

        return [
            'name' => $faker->name(),
            'company_name' => $faker->company(),
            'email' => $faker->safeEmail(),
            'phone' => $faker->phoneNumber(),
            'service_type' => $faker->randomElement($serviceTypes),
            'message' => $faker->paragraph(),
            'is_read' => false,
        ];
    }
}
