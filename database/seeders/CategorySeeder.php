<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $penetratingOils = \App\Models\Category::create([
            'name' => 'Penetrating Oils',
            'slug' => 'penetrating-oils',
            'description' => 'Comprehensive testing of penetrating oils to determine which products work best for loosening rusted bolts and fasteners.',
            'video_urls' => [
                'https://www.youtube.com/watch?v=xUEob2oAKVs',
            ],
        ]);

        $oilAttributes = [
            ['name' => 'Break Loose Torque', 'unit' => 'ft-lbs', 'type' => 'numeric', 'display_order' => 1, 'is_primary_metric' => true],
            ['name' => 'Average Torque', 'unit' => 'ft-lbs', 'type' => 'numeric', 'display_order' => 2, 'is_primary_metric' => false],
            ['name' => 'Price', 'unit' => '$', 'type' => 'numeric', 'display_order' => 3, 'is_primary_metric' => false],
            ['name' => 'Odor Rating', 'unit' => '/10', 'type' => 'numeric', 'display_order' => 4, 'is_primary_metric' => false],
        ];

        foreach ($oilAttributes as $attr) {
            \App\Models\Attribute::create(array_merge($attr, ['category_id' => $penetratingOils->id]));
        }

        $batteries = \App\Models\Category::create([
            'name' => 'AA Batteries',
            'slug' => 'aa-batteries',
            'description' => 'Testing AA batteries to determine runtime, voltage stability, and overall performance under load.',
            'video_urls' => [
                'https://www.youtube.com/watch?v=V7-ghrTqA44',
            ],
        ]);

        $batteryAttributes = [
            ['name' => 'Runtime', 'unit' => 'hours', 'type' => 'numeric', 'display_order' => 1, 'is_primary_metric' => true],
            ['name' => 'Average Voltage', 'unit' => 'V', 'type' => 'numeric', 'display_order' => 2, 'is_primary_metric' => false],
            ['name' => 'Price per Battery', 'unit' => '$', 'type' => 'numeric', 'display_order' => 3, 'is_primary_metric' => false],
            ['name' => 'Cost per Hour', 'unit' => '$/hr', 'type' => 'numeric', 'display_order' => 4, 'is_primary_metric' => true],
        ];

        foreach ($batteryAttributes as $attr) {
            \App\Models\Attribute::create(array_merge($attr, ['category_id' => $batteries->id]));
        }

        $chainsaws = \App\Models\Category::create([
            'name' => 'Chainsaws',
            'slug' => 'chainsaws',
            'description' => 'Head-to-head chainsaw testing measuring cutting speed, power output, and overall performance.',
            'video_urls' => [
                'https://www.youtube.com/watch?v=6gF3fhKlZdg',
            ],
        ]);

        $chainsawAttributes = [
            ['name' => 'Cut Time', 'unit' => 'seconds', 'type' => 'numeric', 'display_order' => 1, 'is_primary_metric' => true],
            ['name' => 'Max RPM', 'unit' => 'rpm', 'type' => 'numeric', 'display_order' => 2, 'is_primary_metric' => false],
            ['name' => 'Weight', 'unit' => 'lbs', 'type' => 'numeric', 'display_order' => 3, 'is_primary_metric' => false],
            ['name' => 'Price', 'unit' => '$', 'type' => 'numeric', 'display_order' => 4, 'is_primary_metric' => false],
            ['name' => 'Bar Length', 'unit' => 'inches', 'type' => 'numeric', 'display_order' => 5, 'is_primary_metric' => false],
        ];

        foreach ($chainsawAttributes as $attr) {
            \App\Models\Attribute::create(array_merge($attr, ['category_id' => $chainsaws->id]));
        }
    }
}
