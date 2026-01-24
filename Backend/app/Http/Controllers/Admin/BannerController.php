<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.banners', compact('banners'));
    }

    public function create()
    {
        return view('admin.create_banner');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        Banner::create([
            'title' => $validated['title'],
            'image_url' => asset('storage/' . $imagePath),
            'link' => $validated['link'],
            'description' => $validated['description'],
            'is_active' => $request->boolean('is_active'),
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner qo\'shildi.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.edit_banner', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image_url) {
                $oldPath = str_replace(asset('storage/'), '', $banner->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image_url = asset('storage/' . $imagePath);
        }

        $banner->update([
            'title' => $validated['title'],
            'image_url' => $banner->image_url,
            'link' => $validated['link'],
            'description' => $validated['description'],
            'is_active' => $request->boolean('is_active'),
            'order' => $validated['order'] ?? $banner->order,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner yangilandi.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image_url) {
            $path = str_replace('/storage/', '', $banner->image_url);
            Storage::disk('public')->delete($path);
        }
        $banner->delete();
        return back()->with('success', 'Banner o\'chirildi.');
    }
}
