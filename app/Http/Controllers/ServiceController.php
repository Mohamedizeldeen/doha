<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Get all services for a salon
     */
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $services = $salon->services()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('services.index', compact('salon', 'services'));
    }

    /**
     * Show service creation form
     */
    public function create(Salon $salon)
    {
        $this->authorize('own', $salon);
        return view('services.create', compact('salon'));
    }

    /**
     * Store a new service
     */
    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        Service::create([
            'salon_id' => $salon->id,
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'description_en' => $validated['description_en'] ?? null,
            'description_ar' => $validated['description_ar'] ?? null,
            'price' => $validated['price'],
            'duration_minutes' => $validated['duration_minutes'],
            'is_active' => true,
        ]);

        return redirect()->route('service.index', $salon)
            ->with('success', 'Service created successfully');
    }

    /**
     * Get a single service with its staff
     */
    public function show(Salon $salon, Service $service)
    {
        $this->authorize('own', $salon);
        $this->authorizeServiceBelongsToSalon($service, $salon);

        $service->load('staff');
        return view('services.show', compact('salon', 'service'));
    }

    /**
     * Show service edit form
     */
    public function edit(Salon $salon, Service $service)
    {
        $this->authorize('own', $salon);
        $this->authorizeServiceBelongsToSalon($service, $salon);

        return view('services.edit', compact('salon', 'service'));
    }

    /**
     * Update a service
     */
    public function update(Request $request, Salon $salon, Service $service)
    {
        $this->authorize('own', $salon);
        $this->authorizeServiceBelongsToSalon($service, $salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $service->update($validated);

        return redirect()->route('service.show', [$salon, $service])
            ->with('success', 'Service updated successfully');
    }

    /**
     * Delete a service
     */
    public function destroy(Salon $salon, Service $service)
    {
        $this->authorize('own', $salon);
        $this->authorizeServiceBelongsToSalon($service, $salon);

        // Detach all staff first
        $service->staff()->detach();

        $service->delete();

        return redirect()->route('service.index', $salon)
            ->with('success', 'Service deleted successfully');
    }

    /**
     * Authorize service belongs to salon
     */
    private function authorizeServiceBelongsToSalon($service, $salon)
    {
        if ($service->salon_id !== $salon->id) {
            abort(403, 'Service does not belong to this salon');
        }
    }
}
