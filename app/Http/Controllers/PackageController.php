<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\ServicePackage;
use App\Models\Service;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $packages = ServicePackage::where('salon_id', $salon->id)
            ->with('services')
            ->orderByDesc('created_at')
            ->get();

        return view('packages.index', compact('salon', 'packages'));
    }

    public function create(Salon $salon)
    {
        $this->authorize('own', $salon);
        $services = $salon->services()->where('is_active', true)->get();
        return view('packages.create', compact('salon', 'services'));
    }

    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'package_price' => 'required|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
        ]);

        // Calculate original price
        $originalPrice = Service::whereIn('id', $validated['services'])->sum('price');

        $package = ServicePackage::create([
            'salon_id' => $salon->id,
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'description_en' => $validated['description_en'] ?? null,
            'description_ar' => $validated['description_ar'] ?? null,
            'original_price' => $originalPrice,
            'package_price' => $validated['package_price'],
            'valid_from' => $validated['valid_from'] ?? null,
            'valid_until' => $validated['valid_until'] ?? null,
        ]);

        $package->services()->attach($validated['services']);

        return redirect()->route('package.index', $salon)
            ->with('success', __('admin.package_created'));
    }

    public function edit(Salon $salon, ServicePackage $package)
    {
        $this->authorize('own', $salon);
        if ($package->salon_id !== $salon->id) abort(403);

        $services = $salon->services()->where('is_active', true)->get();
        $package->load('services');

        return view('packages.edit', compact('salon', 'package', 'services'));
    }

    public function update(Request $request, Salon $salon, ServicePackage $package)
    {
        $this->authorize('own', $salon);
        if ($package->salon_id !== $salon->id) abort(403);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'package_price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
        ]);

        $originalPrice = Service::whereIn('id', $validated['services'])->sum('price');

        $package->update([
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'description_en' => $validated['description_en'] ?? null,
            'description_ar' => $validated['description_ar'] ?? null,
            'original_price' => $originalPrice,
            'package_price' => $validated['package_price'],
            'is_active' => $validated['is_active'] ?? true,
            'valid_from' => $validated['valid_from'] ?? null,
            'valid_until' => $validated['valid_until'] ?? null,
        ]);

        $package->services()->sync($validated['services']);

        return redirect()->route('package.index', $salon)
            ->with('success', __('admin.package_updated'));
    }

    public function destroy(Salon $salon, ServicePackage $package)
    {
        $this->authorize('own', $salon);
        if ($package->salon_id !== $salon->id) abort(403);

        $package->services()->detach();
        $package->delete();

        return redirect()->route('package.index', $salon)
            ->with('success', __('admin.package_deleted'));
    }
}
