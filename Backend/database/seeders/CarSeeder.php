<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return;
        }

        $cars = [
            [
                'title' => 'BMW M5 F90',
                'brand' => 'BMW',
                'model' => 'M5',
                'year' => 2022,
                'price' => 125000,
                'category_id' => $categories->where('name', 'Sedan')->first()->id,
                'fuel_type' => 'Benzin',
                'transmission' => 'Avtomat',
                'condition' => 'Yangi',
                'is_hot_deal' => true,
            ],
            [
                'title' => 'Tesla Model 3',
                'brand' => 'Tesla',
                'model' => 'Model 3',
                'year' => 2023,
                'price' => 45000,
                'category_id' => $categories->where('name', 'Sedan')->first()->id,
                'fuel_type' => 'Elektr',
                'transmission' => 'Avtomat',
                'condition' => 'Yangi',
                'is_hot_deal' => false,
            ],
            [
                'title' => 'Chevrolet Tahoe',
                'brand' => 'Chevrolet',
                'model' => 'Tahoe',
                'year' => 2021,
                'price' => 85000,
                'category_id' => $categories->where('name', 'SUV')->first()->id,
                'fuel_type' => 'Benzin',
                'transmission' => 'Avtomat',
                'condition' => 'Yaxshi',
                'is_hot_deal' => true,
            ],
        ];

        foreach ($cars as $carData) {
            $car = Car::create(array_merge($carData, [
                'user_id' => $user->id,
                'description' => 'Premium car with full options.',
                'status' => 'approved',
                'price_visible' => true,
                'timer_expired' => true,
                'posted_at' => now(),
            ]));
        }
    }
}
