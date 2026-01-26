<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Product;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    /**
     * Show super admin dashboard
     */
    public function dashboard()
    {
        // Get statistics
        $totalSalons = Salon::count();
        $totalProducts = Product::count();
        $totalBookings = Book::count();
        $completedBookings = Book::where('status', 'completed')->count();
        $pendingBookings = Book::where('status', 'scheduled')->count();
        $cancelledBookings = Book::where('status', 'canceled')->count();

        // Get total revenue
        $totalRevenue = Book::where('status', 'completed')->sum('price');

        // Get recent bookings
        $recentBookings = Book::with(['salon', 'client', 'service', 'staff'])
            ->latest()
            ->limit(10)
            ->get();

        // Get salons with booking counts
        $salons = Salon::withCount('bookings')
            ->withCount(['bookings as completed_bookings_count' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->with(['bookings' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->get()
            ->map(function ($salon) {
                $salon->revenue = $salon->bookings->sum('price');
                return $salon;
            });

        // Revenue data by month
        $monthlyRevenue = Book::where('status', 'completed')
            ->selectRaw('MONTH(appointment_datetime) as month, SUM(price) as total')
            ->whereYear('appointment_datetime', now()->year)
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $allMonths = array_fill(1, 12, 0);
        $monthlyRevenue = array_replace($allMonths, $monthlyRevenue);

        return view('superAdmin.dashboard', [
            'totalSalons' => $totalSalons,
            'totalProducts' => $totalProducts,
            'totalBookings' => $totalBookings,
            'completedBookings' => $completedBookings,
            'pendingBookings' => $pendingBookings,
            'cancelledBookings' => $cancelledBookings,
            'totalRevenue' => $totalRevenue,
            'recentBookings' => $recentBookings,
            'salons' => $salons,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    }

    /**
     * Show all salons
     */
    public function salons()
    {
        $salons = Salon::withCount('bookings')
            ->withCount('products')
            ->withCount('services')
            ->withCount('staff')
            ->withCount('clients')
            ->with(['bookings' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->latest()
            ->paginate(15);

        $salons->each(function ($salon) {
            $salon->revenue = $salon->bookings->sum('price');
        });

        return view('superAdmin.salons.index', [
            'salons' => $salons,
        ]);
    }

    /**
     * Show create salon form
     */
    public function createSalon()
    {
        // Get all users that don't have a salon yet
        $users = User::where('role', 'admin')
            ->whereDoesntHave('salons')
            ->get();

        return view('superAdmin.salons.create', compact('users'));
    }

    /**
     * Store a newly created salon
     */
    public function storeSalon(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
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

        $trial_end_date = now()->addDays(14);
        $subscription_end_date = $trial_end_date;

        // Create salon
        $salon = new Salon($validated + ['trial_end_date' => $trial_end_date] + ['subscription_end_date' => $subscription_end_date]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $salon->logo = $path;
        }

        // Convert work_days array to JSON if provided
        if (isset($validated['work_days']) && !empty($validated['work_days'])) {
            $salon->work_days = json_encode($validated['work_days']);
        }

        // Save salon
        $salon->save();

        return redirect()->route('superAdmin.salons.index')
            ->with('success', 'تم إنشاء الصالون بنجاح');
    }

    /**
     * Show salon details
     */
    public function showSalon(Salon $salon)
    {
        $salon->load(['bookings', 'products', 'services', 'staff', 'clients']);
        
        $total_bookings = $salon->bookings->count();
        $completed_bookings = $salon->bookings->where('status', 'completed')->count();
        $revenue = $salon->bookings->where('status', 'completed')->sum('price');

        return view('superAdmin.salons.show', [
            'salon' => $salon,
            'total_bookings' => $total_bookings,
            'completed_bookings' => $completed_bookings,
            'revenue' => $revenue,
        ]);
    }

    /**
     * Show edit salon form
     */
    public function editSalon(Salon $salon)
    {
        return view('superAdmin.salons.edit', compact('salon'));
    }

    /**
     * Update salon information
     */
    public function updateSalon(Request $request, Salon $salon)
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
            'opening_time' => 'nullable|string',
            'closing_time' => 'nullable|string',
            'currency' => 'nullable|string',
            'subscription_type' => 'required|in:trial,monthly,yearly',
            'subscription_start_date' => 'nullable|date',
            'subscription_end_date' => 'nullable|date|after_or_equal:subscription_start_date',
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

        // Update salon
        $salon->update($validated);

        // Handle work days
        if (isset($validated['work_days']) && !empty($validated['work_days'])) {
            $salon->work_days = json_encode($validated['work_days']);
        } else {
            $salon->work_days = null;
        }
        $salon->save();

        return redirect()->route('superAdmin.salons.index')
            ->with('success', 'تم تحديث الصالون بنجاح');
    }

    /**
     * Delete a salon
     */
    public function destroySalon(Salon $salon)
    {
        $salon->delete();

        return redirect()->route('superAdmin.salons.index')
            ->with('success', 'تم حذف الصالون بنجاح');
    }

    /**
     * Show all products
     */
    public function products()
    {
        $products = Product::with('salon')
            ->latest()
            ->paginate(15);

        return view('superAdmin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show all bookings
     */
    public function bookings(Request $request)
    {
        $query = Book::with(['salon', 'client', 'service', 'staff']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by salon
        if ($request->has('salon_id') && $request->salon_id) {
            $query->where('salon_id', $request->salon_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('appointment_datetime', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('appointment_datetime', '<=', $request->date_to);
        }

        $bookings = $query->latest('appointment_datetime')->paginate(20);
        $salons = Salon::all();

        return view('superAdmin.bookings.index', [
            'bookings' => $bookings,
            'salons' => $salons,
            'filters' => $request->only(['status', 'salon_id', 'date_from', 'date_to']),
        ]);
    }

    /**
     * Show booking details
     */
    public function showBooking(Book $booking)
    {
        $booking->load(['salon', 'client', 'service', 'staff']);

        return view('superAdmin.bookings.show', [
            'booking' => $booking,
        ]);
    }

    /**
     * Delete a booking
     */
    public function destroyBooking(Book $booking)
    {
        $booking->delete();

        return redirect()->route('superAdmin.bookings.index')
            ->with('success', 'تم حذف الحجز بنجاح');
    }

    /**
     * Get dashboard statistics via AJAX
     */
    public function getStatistics()
    {
        return response()->json([
            'totalSalons' => Salon::count(),
            'totalProducts' => Product::count(),
            'totalBookings' => Book::count(),
            'totalRevenue' => Book::where('status', 'completed')->sum('price'),
            'thisMonthRevenue' => Book::where('status', 'completed')
                ->whereMonth('appointment_datetime', now()->month)
                ->whereYear('appointment_datetime', now()->year)
                ->sum('price'),
            'thisWeekRevenue' => Book::where('status', 'completed')
                ->whereBetween('appointment_datetime', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('price'),
        ]);
    }
}
