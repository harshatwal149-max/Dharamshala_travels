<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Public: Submit a customer review
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'required|string|max:1000',
            'package_id'    => 'nullable|exists:packages,id',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072', // max 3MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reviews', 'public');
            $validated['image'] = $path;
        }

        $validated['is_approved'] = false; // Admin approval ke baad live hoga

        \App\Models\Review::create($validated);

        return back()->with('success', 'Thank you! Your review and photo have been submitted for moderation.');
    }

    // Public: Show all approved customer reviews
   public function index()
{
    $reviews = Review::where('is_approved', true)
        ->latest()
        ->paginate(12);

    return view('reviews.index', compact('reviews'));
}

    // Admin: List all reviews
    public function adminIndex()
    {
        $reviews = Review::latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    // Admin: Reply or Edit Review
    public function adminUpdate(Request $request, Review $review)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'rating'        => 'required|integer|between:1,5',
            'comment'       => 'required|string|max:1500',
            'admin_reply'   => 'nullable|string|max:2000',
            'is_approved'   => 'nullable|boolean',
        ]);

        $validated['is_approved'] = $request->boolean('is_approved');
        $validated['admin_reply'] = $request->filled('admin_reply') ? trim($request->admin_reply) : null;

        $review->update($validated);

        $msg = $request->filled('admin_reply')
            ? 'Admin reply posted and review updated successfully!'
            : 'Review updated successfully!';

        return back()->with('success', $msg);
    }

    // Admin: Delete Review
    public function adminDestroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully!');
    }
}
