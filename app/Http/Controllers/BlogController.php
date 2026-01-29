<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // SuperAdmin methods
    public function index()
    {
        $blogs = Blog::paginate(10);
        return view('superAdmin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('superAdmin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        Blog::create($validated);

        return redirect()->route('superAdmin.blogs.index')->with('success', 'تم إنشاء المقالة بنجاح');
    }

    public function show(Blog $blog)
    {
        return view('superAdmin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('superAdmin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return redirect()->route('superAdmin.blogs.index')->with('success', 'تم تحديث المقالة بنجاح');
    }

    public function destroy(Blog $blog)
    {
        // Delete image if exists
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('superAdmin.blogs.index')->with('success', 'تم حذف المقالة بنجاح');
    }

    // Public methods
    public function publicIndex()
    {
        $blogs = Blog::paginate(6);
        return view('blogs.index', compact('blogs'));
    }

    public function publicShow(Blog $blog)
    {
        return view('blogs.show', compact('blog'));
    }
}
