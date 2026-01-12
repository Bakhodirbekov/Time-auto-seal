<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Notification;
use Illuminate\Console\Command;

class ExpireCarTimers extends Command
{
    protected $signature = 'cars:expire-timers';
    protected $description = 'Expire car listing timers that have reached their end time';

    public function handle()
    {
        $this->info('Checking for expired timers...');

        // Find all cars with expired timers that haven't been marked as expired yet
        $expiredCars = Car::where('timer_expired', false)
            ->whereNotNull('timer_end_at')
            ->where('timer_end_at', '<=', now())
            ->get();

        $count = 0;

        foreach ($expiredCars as $car) {
            // Mark timer as expired and make price visible
            $car->expireTimer();

            // Notify the car owner
            Notification::create([
                'user_id' => $car->user_id,
                'type' => 'timer_expired',
                'title' => 'Timer Expired',
                'message' => "The 24-hour timer for your car '{$car->title}' has expired. The price is now visible to all users!",
                'data' => [
                    'car_id' => $car->id,
                    'car_title' => $car->title,
                ],
            ]);

            $count++;
            $this->info("Expired timer for car ID: {$car->id} - {$car->title}");
        }

        $this->info("Total timers expired: {$count}");

        return Command::SUCCESS;
    }
}
