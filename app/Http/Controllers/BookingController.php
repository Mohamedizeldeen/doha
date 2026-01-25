<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Book;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display all bookings for a salon
     */
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $bookings = $salon->bookings()
            ->with('client', 'service', 'staff')
            ->orderBy('appointment_datetime', 'desc')
            ->get();

        return view('booking.index', compact('salon', 'bookings'));
    }

    /**
     * Show booking creation form
     */
    public function create(Salon $salon)
    {
        $this->authorize('own', $salon);

        $clients = $salon->clients()->get();
        $services = $salon->services()->where('is_active', true)->get();
        $staff = $salon->staff()->get();


        return view('booking.create', compact('salon', 'clients', 'services', 'staff'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'appointment_datetime' => 'required|date_format:Y-m-d H:i|after:now',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Verify client belongs to salon
        $client = Client::findOrFail($validated['client_id']);
        if ($client->salon_id !== $salon->id) {
            abort(403, 'Client does not belong to this salon');
        }

        // Verify service belongs to salon
        $service = Service::findOrFail($validated['service_id']);
        $this->authorizeServiceBelongsToSalon($service, $salon);

        // Verify staff belongs to salon
        $staff = Staff::findOrFail($validated['staff_id']);
        $this->authorizeStaffBelongsToSalon($staff, $salon);

        // Check if staff provides this service
        if (!$staff->services()->where('service_id', $service->id)->exists()) {
            return back()->withErrors([
                'staff_id' => 'Selected staff member does not provide this service.'
            ])->withInput();
        }

        // Create booking
        $booking = Book::create([
            'salon_id' => $salon->id,
            'client_id' => $validated['client_id'],
            'service_id' => $validated['service_id'],
            'staff_id' => $validated['staff_id'],
            'appointment_datetime' => $validated['appointment_datetime'],
            'price' => $service->price,
            'notes' => $validated['notes'] ?? null,
            'status' => 'scheduled',
        ]);

        return redirect()->route('booking.show', [$salon, $booking])
            ->with('success', 'Booking created successfully');
    }

    /**
     * Display a single booking
     */
    public function show(Salon $salon, Book $booking)
    {
        $this->authorize('own', $salon);

        if ($booking->salon_id !== $salon->id) {
            abort(403);
        }

        $booking->load('client', 'service', 'staff');

        return view('booking.show', compact('salon', 'booking'));
    }

    /**
     * Show booking edit form
     */
    public function edit(Salon $salon, Book $booking)
    {
        $this->authorize('own', $salon);

        if ($booking->salon_id !== $salon->id) {
            abort(403);
        }

        $clients = $salon->clients()->get();
        $services = $salon->services()->where('is_active', true)->get();
        $staff = $salon->staff()->get();

        return view('booking.edit', compact('salon', 'booking', 'clients', 'services', 'staff'));
    }

    /**
     * Update a booking
     */
    public function update(Request $request, Salon $salon, Book $booking)
    {
        $this->authorize('own', $salon);

        if ($booking->salon_id !== $salon->id) {
            abort(403);
        }

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'appointment_datetime' => 'required|date_format:Y-m-d H:i',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Verify relationships
        $client = Client::findOrFail($validated['client_id']);
        if ($client->salon_id !== $salon->id) {
            abort(403);
        }

        $service = Service::findOrFail($validated['service_id']);
        $this->authorizeServiceBelongsToSalon($service, $salon);

        $staff = Staff::findOrFail($validated['staff_id']);
        $this->authorizeStaffBelongsToSalon($staff, $salon);

        // Check if staff provides this service
        if (!$staff->services()->where('service_id', $service->id)->exists()) {
            return back()->withErrors([
                'staff_id' => 'Selected staff member does not provide this service.'
            ])->withInput();
        }

        $booking->update([
            'client_id' => $validated['client_id'],
            'service_id' => $validated['service_id'],
            'staff_id' => $validated['staff_id'],
            'appointment_datetime' => $validated['appointment_datetime'],
            'price' => Service::find($validated['service_id'])->price,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('booking.show', [$salon, $booking])
            ->with('success', 'Booking updated successfully');
    }

    /**
     * Show booking status update form
     */
    public function updateStatusForm(Salon $salon, Book $booking)
    {
        $this->authorize('own', $salon);

        if ($booking->salon_id !== $salon->id) {
            abort(403);
        }

        $booking->load('client', 'service', 'staff');

        return view('booking.status', compact('salon', 'booking'));
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, Salon $salon, Book $booking)
    {
        $this->authorize('own', $salon);

        if ($booking->salon_id !== $salon->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:scheduled,completed,canceled',
        ]);

        $booking->update($validated);

        return redirect()->route('booking.show', [$salon, $booking])
            ->with('success', 'Booking status updated successfully');
    }

    /**
     * Delete a booking
     */
    public function destroy(Salon $salon, Book $booking)
    {
        $this->authorize('own', $salon);

        if ($booking->salon_id !== $salon->id) {
            abort(403);
        }

        $booking->delete();

        return redirect()->route('booking.index', $salon)
            ->with('success', 'Booking deleted successfully');
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

    /**
     * Authorize staff belongs to salon
     */
    private function authorizeStaffBelongsToSalon($staff, $salon)
    {
        if ($staff->salon_id !== $salon->id) {
            abort(403, 'Staff does not belong to this salon');
        }
    }

    /**
     * Show public booking form with real salon data
     */
    public function publicForm($company)
    {
        $salon = Salon::where('name_en', 'like', '%' . $company . '%')
            ->orWhere('name_ar', 'like', '%' . $company . '%')
            ->orWhere('name_en', $company)
            ->orWhere('name_ar', $company)
            ->firstOrFail();

        $services = $salon->services()->where('is_active', true)->get();
        $staff = $salon->staff;
        $products = $salon->products()->get();

        return view('book', compact('salon', 'company', 'services', 'staff', 'products'));
    }

    /**
     * Store public booking from website form
     */
    public function publicStore(Request $request, $company)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'nullable|exists:staff,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
        ]);

        // Find salon by name or company param
        $salon = Salon::where('name_en', 'like', '%' . $company . '%')
            ->orWhere('name_ar', 'like', '%' . $company . '%')
            ->firstOrFail();

        // Create or find client
        $client = Client::firstOrCreate(
            [
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'salon_id' => $salon->id,
            ],
            [
                'client_code' => 'CLT-' . strtoupper(Str::random(8)),
                'name_ar' => $validated['name'],
                'name_en' => $validated['name'],
            ]
        );

        // Combine date and time
        $appointmentDateTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];

        // Check for conflicting bookings if staff is selected
        if ($validated['staff_id']) {
            $service = Service::findOrFail($validated['service_id']);
            $duration = $service->duration_minutes ?? 60;
            
            $appointmentStart = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $appointmentDateTime);
            $appointmentEnd = $appointmentStart->copy()->addMinutes($duration);

            // Fetch nearby bookings with their services to check full duration overlap
            $nearbyBookings = Book::where('staff_id', $validated['staff_id'])
                ->where('salon_id', $salon->id)
                ->where('status', '!=', 'cancelled')
                ->whereBetween('appointment_datetime', [
                    $appointmentStart->copy()->subMinutes(480), // 8 hours before
                    $appointmentEnd->copy()->addMinutes(480)    // 8 hours after
                ])
                ->with('service')
                ->get();

            // Check for overlap: startA < endB && startB < endA
            foreach ($nearbyBookings as $existing) {
                $existingStart = $existing->appointment_datetime instanceof \Carbon\Carbon
                    ? $existing->appointment_datetime
                    : \Carbon\Carbon::parse($existing->appointment_datetime);

                $existingDuration = $existing->service->duration_minutes ?? 60;
                $existingEnd = $existingStart->copy()->addMinutes($existingDuration);

                if ($appointmentStart->lt($existingEnd) && $existingStart->lt($appointmentEnd)) {
                    return back()->withErrors([
                        'appointment_time' => 'هذا الوقت غير متاح للموظف المختار / This time is not available for the selected staff'
                    ])->withInput();
                }
            }
        }

        // Create booking
        $booking = Book::create([
            'salon_id' => $salon->id,
            'client_id' => $client->id,
            'service_id' => $validated['service_id'],
            'staff_id' => $validated['staff_id'] ?? null,
            'appointment_datetime' => $appointmentDateTime,
            'status' => 'scheduled',
        ]);

        return redirect()->route('book', $company)
            ->with('success', 'تم حجز موعدك بنجاح! سيتم التواصل معك قريباً لتأكيد الموعد.');
    }

    /**
     * Check staff availability for a specific date and time
     */
    public function checkStaffAvailability(Request $request, Staff $staff)
    {
        $date = $request->query('date');
        $time = $request->query('time');
        $serviceId = $request->query('service_id');

        if (!$date || !$time || !$serviceId) {
            return response()->json(['available' => false, 'message' => 'Missing parameters'], 400);
        }

        // Get the service to know its duration
        $service = Service::findOrFail($serviceId);
        
        // Get duration in minutes (default 60 if not specified)
        $duration = $service->duration_minutes ?? 60;
        
        $appointmentStart = \Carbon\Carbon::createFromFormat('Y-m-d H:i', "$date $time");
        $appointmentEnd = $appointmentStart->copy()->addMinutes($duration);

        // Fetch nearby bookings with their services to check full duration overlap
        $nearbyBookings = Book::where('staff_id', $staff->id)
            ->where('salon_id', $staff->salon_id)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('appointment_datetime', [
                $appointmentStart->copy()->subMinutes(480), // 8 hours before
                $appointmentEnd->copy()->addMinutes(480)    // 8 hours after
            ])
            ->with('service')
            ->get();

        // Check for overlap: startA < endB && startB < endA
        foreach ($nearbyBookings as $existing) {
            $existingStart = $existing->appointment_datetime instanceof \Carbon\Carbon
                ? $existing->appointment_datetime
                : \Carbon\Carbon::parse($existing->appointment_datetime);

            $existingDuration = $existing->service->duration_minutes ?? 60;
            $existingEnd = $existingStart->copy()->addMinutes($existingDuration);

            if ($appointmentStart->lt($existingEnd) && $existingStart->lt($appointmentEnd)) {
                return response()->json([
                    'available' => false,
                    'message' => 'Staff member is not available at this time'
                ]);
            }
        }

        return response()->json([
            'available' => true,
            'message' => 'Staff member is available'
        ]);
    }
}
