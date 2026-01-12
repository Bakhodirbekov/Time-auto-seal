<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'car_timer_duration',
                'value' => '24',
                'type' => 'integer',
                'description' => 'Car listing timer duration in hours'
            ],
            [
                'key' => 'require_car_approval',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Require admin approval for new car listings'
            ],
            [
                'key' => 'max_images_per_car',
                'value' => '10',
                'type' => 'integer',
                'description' => 'Maximum number of images per car listing'
            ],
            [
                'key' => 'site_name',
                'value' => 'InsofAuto',
                'type' => 'string',
                'description' => 'Website name'
            ],
            [
                'key' => 'enable_notifications',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable user notifications'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
