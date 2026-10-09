<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display all blogs.
     */
    public function index()
    {
        $blogs = Blog::latest('blog_date')
            ->latest('id')
            ->paginate(15);

        return view('admin.blogs.index', compact('blogs'));
    }


    /**
     * Show create blog form.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }


    /**
     * Store new blog.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
            ],

            'description' => 'required|string',

            'blog_date' => 'required|date',

            'multiple_images' => [
                'nullable',
                'array',
            ],

            'multiple_images.*' => [
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
            ],
        ]);


        $blog = new Blog();

        $blog->title = $validated['title'];
        $blog->description = $validated['description'];
        $blog->blog_date = $validated['blog_date'];


        // Main image
        if ($request->hasFile('image')) {

            $path = $request->file('image')
                ->store('blogs', 'public');

            $blog->image = asset('storage/' . $path);
        }


        // Multiple optional images
        $multipleImages = [];

        if ($request->hasFile('multiple_images')) {

            foreach ($request->file('multiple_images') as $image) {

                $path = $image->store('blogs/gallery', 'public');

                $multipleImages[] = asset('storage/' . $path);
            }
        }

        $blog->multiple_images = $multipleImages ?: null;

        $blog->save();


        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog created successfully!');
    }


    /**
     * Show edit blog form.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }


    /**
     * Update blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
            ],

            'description' => 'required|string',

            'blog_date' => 'required|date',

            'multiple_images' => [
                'nullable',
                'array',
            ],

            'multiple_images.*' => [
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
            ],
        ]);


        $blog->title = $validated['title'];
        $blog->description = $validated['description'];
        $blog->blog_date = $validated['blog_date'];


        // Replace main image only if new image uploaded
        if ($request->hasFile('image')) {

            $path = $request->file('image')
                ->store('blogs', 'public');

            $blog->image = asset('storage/' . $path);
        }


        // Add newly uploaded gallery images
        if ($request->hasFile('multiple_images')) {

            $existingImages = $blog->multiple_images ?? [];

            foreach ($request->file('multiple_images') as $image) {

                $path = $image->store('blogs/gallery', 'public');

                $existingImages[] = asset('storage/' . $path);
            }

            $blog->multiple_images = $existingImages;
        }


        $blog->save();


        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully!');
    }


    /**
     * Delete blog.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully!');
    }
}