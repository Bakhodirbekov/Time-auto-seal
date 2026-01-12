<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of cars
     */
    public function index(Request $request)
    {
        $query = Car::with(['category', 'subcategory', 'images', 'user'])
            ->approved();

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by subcategory
        if ($request->has('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by hot deals
        if ($request->has('hot_deals') && $request->hot_deals) {
            $query->hotDeals();
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by year
        if ($request->has('year')) {
            $query->where('year', $request->year);
        }

        // Filter by fuel type
        if ($request->has('fuel_type') && $request->fuel_type) {
            $query->where('fuel_type', $request->fuel_type);
        }

        // Filter by transmission
        if ($request->has('transmission') && $request->transmission) {
            $query->where('transmission', $request->transmission);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $cars = $query->paginate($request->get('per_page', 15));

        // Add remaining time for each car
        $cars->getCollection()->transform(function ($car) {
            $car->remaining_time = $car->getRemainingTime();
            return $car;
        });

        return response()->json($cars);
    }

    /**
     * Get hot deals
     */
    public function hotDeals(Request $request)
    {
        $cars = Car::with(['category', 'subcategory', 'images', 'user'])
            ->approved()
            ->hotDeals()
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        $cars->getCollection()->transform(function ($car) {
            $car->remaining_time = $car->getRemainingTime();
            return $car;
        });

        return response()->json($cars);
    }

    /**
     * Display the specified car
     */
    public function show($id)
    {
        $car = Car::with(['category', 'subcategory', 'images', 'user'])
            ->findOrFail($id);

        // Check if car is approved
        if ($car->status !== 'approved' && (!auth()->check() || auth()->id() !== $car->user_id)) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $car->remaining_time = $car->getRemainingTime();
        $car->timer_expired_status = $car->isTimerExpired();

        return response()->json($car);
    }

    /**
     * Store a newly created car
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
            'mileage' => 'nullable|integer|min:0',
            'fuel_type' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'condition' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $car = Car::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'color' => $request->color,
            'mileage' => $request->mileage,
            'fuel_type' => $request->fuel_type,
            'transmission' => $request->transmission,
            'condition' => $request->condition,
            'location' => $request->location,
            'status' => 'pending',
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('cars', 'public');
                CarImage::create([
                    'car_id' => $car->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'order' => $index,
                ]);
            }
        }

        $car->load(['category', 'subcategory', 'images']);

        return response()->json([
            'message' => 'Car listing created successfully. Waiting for admin approval.',
            'car' => $car,
        ], 201);
    }

    /**
     * Update the specified car
     */
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        // Check ownership
        if ($car->user_id !== auth()->id() && !auth()->user()->canManageCars()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'brand' => 'sometimes|string|max:255',
            'model' => 'sometimes|string|max:255',
            'year' => 'sometimes|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
            'mileage' => 'nullable|integer|min:0',
            'fuel_type' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'condition' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
        ]);

        $car->update($request->only([
            'category_id', 'subcategory_id', 'title', 'description', 'price',
            'brand', 'model', 'year', 'color', 'mileage', 'fuel_type',
            'transmission', 'condition', 'location'
        ]));

        return response()->json([
            'message' => 'Car updated successfully',
            'car' => $car->load(['category', 'subcategory', 'images']),
        ]);
    }

    /**
     * Remove the specified car
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // Check ownership
        if ($car->user_id !== auth()->id() && !auth()->user()->canManageCars()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete images
        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $car->delete();

        return response()->json([
            'message' => 'Car deleted successfully',
        ]);
    }

    /**
     * Get user's cars
     */
    public function myCars(Request $request)
    {
        $cars = Car::with(['category', 'subcategory', 'images'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        $cars->getCollection()->transform(function ($car) {
            $car->remaining_time = $car->getRemainingTime();
            return $car;
        });

        return response()->json($cars);
    }
}
