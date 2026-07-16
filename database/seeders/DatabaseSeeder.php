<?php

namespace Database\Seeders;

use App\Models\ContactRequest;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);

        $serviceTypes = array_keys(ContactRequest::serviceTypes());
        $names = [
            ['name' => 'Adam Nowicki', 'company_name' => 'TechSolutions Sp. z o.o.', 'email' => 'adam@techsolutions.pl', 'phone' => '+48 22 555 1234'],
            ['name' => 'Katarzyna Wiśniewska', 'company_name' => 'Kwiaciarnia Kasia', 'email' => 'kasia@kwiaciarniakasia.pl', 'phone' => '+48 661 234 567'],
            ['name' => 'Tomasz Zieliński', 'company_name' => 'Wspólnota Mieszkaniowa "Leśna"', 'email' => 'tz@wm-lesna.pl', 'phone' => '+48 17 888 9900'],
            ['name' => 'Marta Lewandowska', 'company_name' => 'Lewandowska Kancelaria', 'email' => 'marta@lewandowska-kancelaria.pl', 'phone' => '+48 501 345 678'],
            ['name' => 'Piotr Kamiński', 'company_name' => 'Kamiński Trade', 'email' => 'piotr@kaminski-trade.pl', 'phone' => '+48 602 456 789'],
        ];

        foreach ($names as $i => $data) {
            ContactRequest::create(array_merge($data, [
                'service_type' => $serviceTypes[$i % count($serviceTypes)],
                'message' => 'Prosimy o wycenę usług sprzątania dla naszego obiektu.',
                'is_read' => false,
            ]));
        }
    }
}
