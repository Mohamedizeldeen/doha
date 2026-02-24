<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Salon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);
        $categories = $salon->categories()->withCount('services')->get();
        return view('categories.index', compact('salon', 'categories'));
    }

    public function create(Salon $salon)
    {
        $this->authorize('own', $salon);
        return view('categories.create', compact('salon'));
    }

    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);

        $salon->categories()->create($validated);

        return redirect()->route('category.index', $salon)
            ->with('success', __('messages.category_created'));
    }

    public function edit(Salon $salon, Category $category)
    {
        $this->authorize('own', $salon);
        $this->authorizeCategoryBelongsToSalon($category, $salon);

        return view('categories.edit', compact('salon', 'category'));
    }

    public function update(Request $request, Salon $salon, Category $category)
    {
        $this->authorize('own', $salon);
        $this->authorizeCategoryBelongsToSalon($category, $salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('category.index', $salon)
            ->with('success', __('messages.category_updated'));
    }

    public function destroy(Salon $salon, Category $category)
    {
        $this->authorize('own', $salon);
        $this->authorizeCategoryBelongsToSalon($category, $salon);

        $category->delete();

        return redirect()->route('category.index', $salon)
            ->with('success', __('messages.category_deleted'));
    }

    private function authorizeCategoryBelongsToSalon(Category $category, Salon $salon)
    {
        if ($category->salon_id !== $salon->id) {
            abort(403, __('messages.unauthorized'));
        }
    }
}
