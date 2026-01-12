<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Get user's favorites
     */
    public function index(Request $request)
    {
        $favorites = auth()->user()
            ->favorites()
            ->with(['category', 'subcategory', 'images'])
            ->approved()
            ->paginate($request->get('per_page', 15));

        return response()->json($favorites);
    }

    /**
     * Add car to favorites
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
        ]);

        $user = auth()->user();
        
        if ($user->favorites()->where('car_id', $request->car_id)->exists()) {
            return response()->json(['message' => 'Car already in favorites'], 400);
        }

        $user->favorites()->attach($request->car_id);

        return response()->json(['message' => 'Car added to favorites'], 201);
    }

    /**
     * Remove car from favorites
     */
    public function destroy($carId)
    {
        auth()->user()->favorites()->detach($carId);

        return response()->json(['message' => 'Car removed from favorites']);
    }

    /**
     * Check if car is in favorites
     */
    public function check($carId)
    {
        $isFavorite = auth()->user()->favorites()->where('car_id', $carId)->exists();

        return response()->json(['is_favorite' => $isFavorite]);
    }
}
