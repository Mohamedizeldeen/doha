<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Staff;
use App\Models\Service;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Get all staff for a salon
     */
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $staff = $salon->staff()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.index', compact('salon', 'staff'));
    }

    /**
     * Show staff creation form
     */
    public function create(Salon $salon)
    {
        $this->authorize('own', $salon);
        $services = $salon->services()->get();
        return view('staff.create', compact('salon', 'services'));
    }

    /**
     * Store a new staff member
     */
    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($salon) {
                    $exists = Staff::where('salon_id', $salon->id)
                        ->where('email', $value)
                        ->exists();
                    if ($exists) {
                        $fail('Email already registered for this salon.');
                    }
                },
            ],
            'phone' => 'required|regex:/^[0-9+\-\s()]{7,20}$/',
            'position_en' => 'required|string|max:255',
            'position_ar' => 'required|string|max:255',
            'services' => 'nullable|array|max:5',
            'services.*' => 'required|integer|exists:services,id',
        ]);

        $staff = Staff::create([
            'salon_id' => $salon->id,
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position_en' => $validated['position_en'],
            'position_ar' => $validated['position_ar'],
        ]);

        // Attach services if provided
        if (!empty($validated['services'])) {
            $serviceCount = Service::whereIn('id', $validated['services'])
                ->where('salon_id', $salon->id)
                ->count();

            if ($serviceCount === count($validated['services'])) {
                $staff->services()->attach($validated['services']);
            }
        }

        return redirect()->route('staff.index', $salon)
            ->with('success', 'Staff member created successfully');
    }

    /**
     * Get a single staff member with services
     */
    public function show(Salon $salon, Staff $staff)
    {
        $this->authorize('own', $salon);
        $this->authorizeStaffBelongsToSalon($staff, $salon);

        $staff->load('services');
        return view('staff.show', compact('salon', 'staff'));
    }

    /**
     * Show staff edit form
     */
    public function edit(Salon $salon, Staff $staff)
    {
        $this->authorize('own', $salon);
        $this->authorizeStaffBelongsToSalon($staff, $salon);

        $services = $salon->services()->get();
        return view('staff.edit', compact('salon', 'staff', 'services'));
    }

    /**
     * Update a staff member
     */
    public function update(Request $request, Salon $salon, Staff $staff)
    {
        $this->authorize('own', $salon);
        $this->authorizeStaffBelongsToSalon($staff, $salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($salon, $staff) {
                    $exists = Staff::where('salon_id', $salon->id)
                        ->where('email', $value)
                        ->where('id', '!=', $staff->id)
                        ->exists();
                    if ($exists) {
                        $fail('Email already registered for another staff member in this salon.');
                    }
                },
            ],
            'phone' => 'required|regex:/^[0-9+\-\s()]{7,20}$/',
            'position_en' => 'required|string|max:255',
            'position_ar' => 'required|string|max:255',
            'services' => 'nullable|array|max:5',
            'services.*' => 'required|integer|exists:services,id',
        ]);

        $staff->update($validated);

        // Update services
        if (isset($validated['services'])) {
            $staff->services()->sync($validated['services']);
        }

        return redirect()->route('staff.show', [$salon, $staff])
            ->with('success', 'Staff member updated successfully');
    }

    /**
     * Delete a staff member
     */
    public function destroy(Salon $salon, Staff $staff)
    {
        $this->authorize('own', $salon);
        $this->authorizeStaffBelongsToSalon($staff, $salon);

        // Detach all services first
        $staff->services()->detach();

        // Delete all associated bookings
        $staff->bookings()->delete();

        $staff->delete();

        return redirect()->route('staff.index', $salon)
            ->with('success', 'Staff member deleted successfully');
    }

    /**
     * Get services for a specific staff member (API endpoint)
     */
    public function getServices(Salon $salon, Staff $staff)
    {
        $this->authorizeStaffBelongsToSalon($staff, $salon);

        $services = $staff->services()->select('id', 'name_ar', 'name_en', 'price')->get();

        return response()->json($services);
    }

    /**
     * Authorize staff belongs to salon
     */
    private function authorizeStaffBelongsToSalon($staff, $salon)
    {
        if ($staff->salon_id !== $salon->id) {
            abort(403, 'Staff member does not belong to this salon');
        }
    }
}
