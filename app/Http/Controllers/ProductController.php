<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Get all products for a salon
     */
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $products = $salon->products()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('products.index', compact('salon', 'products'));
    }

    /**
     * Show product creation form
     */
    public function create(Salon $salon)
    {
        $this->authorize('own', $salon);
        return view('products.create', compact('salon'));
    }

    /**
     * Store a new product
     */
    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(
                "products/salon-{$salon->id}",
                'public'
            );
        }

        Product::create([
            'salon_id' => $salon->id,
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'description_en' => $validated['description_en'] ?? null,
            'description_ar' => $validated['description_ar'] ?? null,
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'image' => $imagePath ?? null,
        ]);

        return redirect()->route('product.index', $salon)
            ->with('success', 'تم إنشاء المنتج بنجاح');
    }

    /**
     * Get a single product
     */
    public function show(Salon $salon, Product $product)
    {
        $this->authorize('own', $salon);
        $this->authorizeProductBelongsToSalon($product, $salon);

        return view('products.show', compact('salon', 'product'));
    }

    /**
     * Show product edit form
     */
    public function edit(Salon $salon, Product $product)
    {
        $this->authorize('own', $salon);
        $this->authorizeProductBelongsToSalon($product, $salon);

        return view('products.edit', compact('salon', 'product'));
    }

    /**
     * Update a product
     */
    public function update(Request $request, Salon $salon, Product $product)
    {
        $this->authorize('own', $salon);
        $this->authorizeProductBelongsToSalon($product, $salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store(
                "products/salon-{$salon->id}",
                'public'
            );
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('product.show', [$salon, $product])
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    /**
     * Delete a product
     */
    public function destroy(Salon $salon, Product $product)
    {
        $this->authorize('own', $salon);
        $this->authorizeProductBelongsToSalon($product, $salon);

        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('product.index', $salon)
            ->with('success', 'تم حذف المنتج بنجاح');
    }

    /**
     * Authorize product belongs to salon
     */
    private function authorizeProductBelongsToSalon($product, $salon)
    {
        if ($product->salon_id !== $salon->id) {
            abort(403, 'Unauthorized action.ٍ');
        }
    }
}
