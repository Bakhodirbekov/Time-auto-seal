<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_cars' => Car::count(),
            'pending_cars' => Car::pending()->count(),
            'approved_cars' => Car::approved()->count(),
            'active_timers' => Car::timerActive()->count(),
            'expired_timers' => Car::timerExpired()->count(),
            'hot_deals' => Car::hotDeals()->count(),
            'total_users' => User::where('role', 'user')->count(),
            'blocked_users' => User::where('is_blocked', true)->count(),
            'pending_complaints' => Complaint::pending()->count(),
        ];

        return response()->json($stats);
    }

    public function stats()
    {
        // Recent cars
        $recentCars = Car::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Cars expiring soon
        $expiringSoon = Car::with(['user', 'category'])
            ->timerActive()
            ->orderBy('timer_end_at', 'asc')
            ->limit(10)
            ->get();

        return response()->json([
            'recent_cars' => $recentCars,
            'expiring_soon' => $expiringSoon,
        ]);
    }
}
