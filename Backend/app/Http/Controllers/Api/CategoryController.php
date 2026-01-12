<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Category::with('subcategories')
            ->active()
            ->orderBy('order')
            ->get();

        return response()->json($categories);
    }

    /**
     * Display the specified category
     */
    public function show($id)
    {
        $category = Category::with('subcategories')->findOrFail($id);
        return response()->json($category);
    }
}
