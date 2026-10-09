<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    /**
     * Show all hero banners.
     */
    public function index()
    {
        $banners = HeroBanner::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.banner', compact('banners'));
    }

    /**
     * Add new hero banner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'nullable|string|max:200',
            'subtitle' => 'nullable|string|max:500',
        ]);

        $path = $request->file('image')->store('hero-banners', 'public');

        HeroBanner::create([
            'image' => $path,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'is_active' => true,
            'sort_order' => ((int) HeroBanner::max('sort_order')) + 1,
        ]);

        return back()->with('success', 'Banner added successfully!');
    }

    /**
     * Update existing hero banner.
     */
    public function update(Request $request, HeroBanner $heroBanner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'nullable|string|max:200',
            'subtitle' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        /*
         * Update image only if a new image was uploaded.
         */
        if ($request->hasFile('image')) {
            if ($heroBanner->image) {
                Storage::disk('public')->delete($heroBanner->image);
            }

            $heroBanner->image = $request->file('image')
                ->store('hero-banners', 'public');
        }

        $heroBanner->title = $request->title;
        $heroBanner->subtitle = $request->subtitle;
        $heroBanner->is_active = $request->boolean('is_active');

        if ($request->filled('sort_order')) {
            $heroBanner->sort_order = (int) $request->sort_order;
        }

        $heroBanner->save();

        return back()->with('success', 'Banner updated successfully!');
    }

    /**
     * Delete hero banner.
     */
    public function destroy(HeroBanner $heroBanner)
    {
        if ($heroBanner->image) {
            Storage::disk('public')->delete($heroBanner->image);
        }

        $heroBanner->delete();

        return back()->with('success', 'Banner deleted successfully!');
    }
}