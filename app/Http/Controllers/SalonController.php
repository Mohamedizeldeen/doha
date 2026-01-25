<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SalonController extends Controller
{
    /**
     * Show all user's salons
     */
    public function index()
    {
        $salons = Auth::user()->salons;
        return view('salon.index', compact('salons'));
    }

    /**
     * Show create salon form
     */
    public function create()
    {
        return view('salon.create');
    }

    /**
     * Store a newly created salon
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'nullable|string|max:500',
            'address_ar' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subscription_type' => 'required|in:trial,monthly,yearly',
            'opening_time' => 'nullable|string',
            'closing_time' => 'nullable|string',
            'currency' => 'nullable|string',
            'work_days' => 'nullable|array',
            'work_days.*' => 'string',
        ]);

        //check if the user have already a salon
        if (Auth::user()->salons()->count() > 0) {
            return redirect()->back()->withErrors(['You can only create one salon.']);
        }

        $trial_end_date = now()->addDays(14);
        $subscription_end_date = $trial_end_date;

        // Create salon
        $salon = new Salon($validated + ['trial_end_date' => $trial_end_date]+ ['subscription_end_date' => $subscription_end_date]);
        $salon->user_id = Auth::id();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $salon->logo = $path;
        }

        // Convert work_days array to JSON if provided
        if (isset($validated['work_days']) && !empty($validated['work_days'])) {
            $salon->work_days = json_encode($validated['work_days']);
        }

        // Set subscription dates based on type
        $salon->setSubscriptionDates();

        // Save salon
        $salon->save();

        // Create default admin user for this salon (the logged-in user)
        // This can be done through a SalonUser model if you have one, or directly here
        // For now, we're establishing that the authenticated user is the admin of this salon

        return redirect()->route('admin.dashboard', ['salon_id' => $salon->id])
            ->with('success', 'Salon created successfully! Your trial period starts now.');
    }

    /**
     * Show salon details
     */
    public function show($id)
    {
        $salon = Salon::findOrFail($id);
        $this->authorizeUser($salon);
        return view('settings.show', compact('salon'));
    }

    /**
     * Show settings page for authenticated user's salon
     */
    public function settingsShow()
    {
        $salon = Auth::user()->salons()->first();
        if (!$salon) {
            abort(404, 'Salon not found');
        }
        return view('settings.show', compact('salon'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $salon = Salon::findOrFail($id);
        $this->authorizeUser($salon);
        return view('settings.edit', compact('salon'));
    }

    public function update(Request $request, $id)
    {
        $salon = Salon::findOrFail($id);
        $this->authorizeUser($salon);

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'nullable|string|max:500',
            'address_ar' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opening_time' => 'nullable|string',
            'closing_time' => 'nullable|string',
            'currency' => 'nullable|string',
            'work_days' => 'nullable|array',
            'work_days.*' => 'string',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($salon->logo) {
                Storage::disk('public')->delete($salon->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        // Convert work_days array to JSON
        if (isset($validated['work_days'])) {
            $validated['work_days'] = json_encode($validated['work_days']);
        }

        $salon->update($validated);

        return redirect()->route('settings.show')
            ->with('success', 'تم تحديث إعدادات الصالون بنجاح!');
    }

    /**
     * Delete salon
     */
    public function destroy($id)
    {
        $salon = Salon::findOrFail($id);
        $this->authorizeUser($salon);

        // Delete logo if exists
        if ($salon->logo) {
            Storage::disk('public')->delete($salon->logo);
        }

        $salon->delete();

        return redirect()->route('salon.index')
            ->with('success', 'Salon deleted successfully!');
    }

    /**
     * Get salon details (API)
     */
    public function getDetails($id)
    {
        $salon = Salon::findOrFail($id);
        $this->authorizeUser($salon);
        return response()->json($salon);
    }

    public function updateDetails(Request $request, $id)
    {
        $salon = Salon::findOrFail($id);
        $this->authorizeUser($salon);
        
        $validated = $request->validate([
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'address_en' => 'nullable|string|max:500',
            'address_ar' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'opening_time' => 'nullable|string',
            'closing_time' => 'nullable|string',
            'currency' => 'nullable|string',
            'work_days' => 'nullable|array',
            'work_days.*' => 'string',
        ]);

        // Convert work_days array to JSON
        if (isset($validated['work_days'])) {
            $validated['work_days'] = json_encode($validated['work_days']);
        }

        $salon->update($validated);
        return response()->json(['message' => 'Salon updated successfully', 'salon' => $salon]);
    }

    /**
     * Delete salon (API)
     */
    public function deleteSalon($id)
    {
        $salon = Salon::findOrFail($id);
        $this->authorizeUser($salon);

        if ($salon->logo) {
            Storage::disk('public')->delete($salon->logo);
        }

        $salon->delete();
        return response()->json(['message' => 'Salon deleted successfully']);
    }

    /**
     * Authorize user for salon
     */
    private function authorizeUser($salon)
    {
        if ($salon->user_id !== Auth::id()) {
            abort(403, 'Unauthorized to access this salon.');
        }
    }

    /**
     * Show settings edit form for authenticated user's salon
     */
    public function settingsEdit()
    {
        $salon = Auth::user()->salons()->first();
        if (!$salon) {
            abort(404, 'Salon not found');
        }
        return view('settings.edit', compact('salon'));
    }

    public function settingsUpdate(Request $request)
    {
        $salon = Auth::user()->salons()->first();
        if (!$salon) {
            abort(404, 'Salon not found');
        }

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'nullable|string|max:500',
            'address_ar' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opening_time' => 'nullable|string',
            'closing_time' => 'nullable|string',
            'currency' => 'nullable|string',
            'work_days' => 'nullable|array',
            'work_days.*' => 'string',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($salon->logo) {
                Storage::disk('public')->delete($salon->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        // Convert work_days array to JSON
        if (isset($validated['work_days'])) {
            $validated['work_days'] = json_encode($validated['work_days']);
        }

        $salon->update($validated);

        return redirect()->route('settings.show')
            ->with('success', 'تم تحديث إعدادات الصالون بنجاح!');
    }
}
