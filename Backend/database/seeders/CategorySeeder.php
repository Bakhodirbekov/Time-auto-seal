<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sedan',
                'description' => 'Passenger sedans and family cars',
                'icon' => 'sedan',
                'subcategories' => ['Compact', 'Mid-size', 'Full-size', 'Luxury']
            ],
            [
                'name' => 'SUV',
                'description' => 'Sport Utility Vehicles',
                'icon' => 'suv',
                'subcategories' => ['Compact SUV', 'Mid-size SUV', 'Full-size SUV', 'Luxury SUV']
            ],
            [
                'name' => 'Truck',
                'description' => 'Pickup trucks and commercial vehicles',
                'icon' => 'truck',
                'subcategories' => ['Light Duty', 'Heavy Duty', 'Commercial']
            ],
            [
                'name' => 'Coupe',
                'description' => 'Sport coupes and two-door cars',
                'icon' => 'coupe',
                'subcategories' => ['Sport Coupe', 'Luxury Coupe']
            ],
            [
                'name' => 'Hatchback',
                'description' => 'Compact hatchback vehicles',
                'icon' => 'hatchback',
                'subcategories' => ['Small', 'Medium', 'Large']
            ],
        ];

        foreach ($categories as $index => $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'icon' => $categoryData['icon'],
                'order' => $index + 1,
                'is_active' => true,
            ]);

            // Create subcategories
            if (isset($categoryData['subcategories'])) {
                foreach ($categoryData['subcategories'] as $subIndex => $subName) {
                    Subcategory::create([
                        'category_id' => $category->id,
                        'name' => $subName,
                        'slug' => Str::slug($subName),
                        'order' => $subIndex + 1,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
