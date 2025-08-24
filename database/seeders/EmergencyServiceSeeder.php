<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmergencyService;

class EmergencyServiceSeeder extends Seeder
{
    public function run(): void
    {
        EmergencyService::factory()->create([
            'name' => 'ونش سريع دمشق',
            'type' => 'رافعة',
            'city' => 'دمشق',
            'lat'  => 33.5138,
            'lng'  => 36.2765,
            'phone'=> '0999123456',
        ]);

        EmergencyService::factory()->create([
            'name' => 'صيانة طريق حلب',
            'type' => 'مركز صيانة',
            'city' => 'حلب',
            'lat'  => 36.2021,
            'lng'  => 37.1343,
            'phone'=> '0933123456',
        ]);
    }
}
