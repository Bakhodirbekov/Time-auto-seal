<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['user', 'category', 'subcategory', 'images']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($cars);
    }

    public function pending(Request $request)
    {
        $cars = Car::with(['user', 'category', 'subcategory', 'images'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($cars);
    }

    public function show($id)
    {
        $car = Car::with(['user', 'category', 'subcategory', 'images'])->findOrFail($id);
        return response()->json($car);
    }

    public function approve(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        
        $car->update(['status' => 'approved']);
        
        // Start timer
        $timerDuration = $request->get('timer_duration', config('app.car_timer_duration', 24));
        $car->startTimer($timerDuration);

        // Notify user
        Notification::create([
            'user_id' => $car->user_id,
            'type' => 'car_approved',
            'title' => 'Car Approved',
            'message' => "Your car listing '{$car->title}' has been approved!",
            'data' => ['car_id' => $car->id],
        ]);

        return response()->json([
            'message' => 'Car approved successfully',
            'car' => $car,
        ]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string',
        ]);

        $car = Car::findOrFail($id);
        $car->update(['status' => 'rejected']);

        // Notify user
        $message = "Your car listing '{$car->title}' has been rejected.";
        if ($request->reason) {
            $message .= " Reason: {$request->reason}";
        }

        Notification::create([
            'user_id' => $car->user_id,
            'type' => 'car_rejected',
            'title' => 'Car Rejected',
            'message' => $message,
            'data' => ['car_id' => $car->id, 'reason' => $request->reason],
        ]);

        return response()->json([
            'message' => 'Car rejected',
            'car' => $car,
        ]);
    }

    public function toggleHotDeal($id)
    {
        $car = Car::findOrFail($id);
        $car->update(['is_hot_deal' => !$car->is_hot_deal]);

        return response()->json([
            'message' => $car->is_hot_deal ? 'Added to hot deals' : 'Removed from hot deals',
            'car' => $car,
        ]);
    }

    public function startTimer(Request $request, $id)
    {
        $request->validate([
            'hours' => 'nullable|integer|min:1',
        ]);

        $car = Car::findOrFail($id);
        $car->startTimer($request->get('hours'));

        return response()->json([
            'message' => 'Timer started',
            'car' => $car,
        ]);
    }

    public function expireTimer($id)
    {
        $car = Car::findOrFail($id);
        $car->expireTimer();

        // Notify user
        Notification::create([
            'user_id' => $car->user_id,
            'type' => 'timer_expired',
            'title' => 'Timer Expired',
            'message' => "The timer for your car '{$car->title}' has expired. Price is now visible!",
            'data' => ['car_id' => $car->id],
        ]);

        return response()->json([
            'message' => 'Timer expired manually',
            'car' => $car,
        ]);
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,approved,rejected,sold',
            'is_featured' => 'sometimes|boolean',
            'is_hot_deal' => 'sometimes|boolean',
        ]);

        $car->update($request->all());

        return response()->json([
            'message' => 'Car updated successfully',
            'car' => $car,
        ]);
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $car->delete();

        return response()->json(['message' => 'Car deleted successfully']);
    }
}
