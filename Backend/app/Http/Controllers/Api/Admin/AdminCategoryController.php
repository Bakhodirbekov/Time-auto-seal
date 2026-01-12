<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->orderBy('order')->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon,
            'order' => $request->order ?? 0,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category,
        ], 201);
    }

    public function show($id)
    {
        $category = Category::with('subcategories')->findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $category->update($request->all());

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category,
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

    // Subcategory methods
    public function storeSubcategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:subcategories,slug',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $subcategory = Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Subcategory created successfully',
            'subcategory' => $subcategory,
        ], 201);
    }

    public function updateSubcategory(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:subcategories,slug,' . $id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $subcategory->update($request->all());

        return response()->json([
            'message' => 'Subcategory updated successfully',
            'subcategory' => $subcategory,
        ]);
    }

    public function destroySubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();

        return response()->json(['message' => 'Subcategory deleted successfully']);
    }
}
