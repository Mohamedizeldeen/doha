<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Product;
use App\Models\Book;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    /**
     * Show super admin dashboard
     */
    public function dashboard()
    {
        // Salon stats
        $totalSalons = Salon::count();
        $activeSalons = Salon::where('subscription_end_date', '>=', now())->count();
        $trialSalons = Salon::where('subscription_type', 'trial')->count();
        $paidSalons = Salon::whereIn('subscription_type', ['monthly', 'yearly'])->count();

        // App subscription income (from payments table)
        $totalIncome = Payment::paid()->sum('amount');
        $monthlySubIncome = Payment::paid()->where('subscription_type', 'monthly')->sum('amount');
        $yearlySubIncome = Payment::paid()->where('subscription_type', 'yearly')->sum('amount');
        $totalCommissionsPaid = Payment::paid()->sum('commission_amount');

        // This month's income
        $thisMonthIncome = Payment::paid()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        // Subscription alerts
        $overdueSalons = Salon::where('subscription_end_date', '<', now())->with('user')->get();
        $expiringSoon = Salon::where('subscription_end_date', '>', now())
            ->where('subscription_end_date', '<=', now()->addDays(7))
            ->with('user')->get();

        // Sales people stats
        $salesUsers = User::where('role', 'sales')
            ->withCount('soldSalons')
            ->get()
            ->map(function ($sales) {
                $sales->total_commission = $sales->totalCommissionEarned();
                return $sales;
            });

        // Monthly income data for chart (subscription payments by month)
        $monthlyIncome = Payment::paid()
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $allMonths = array_fill(1, 12, 0);
        $monthlyIncome = array_replace($allMonths, $monthlyIncome);

        // Subscription type distribution for doughnut chart
        $subscriptionStats = [
            'trial' => $trialSalons,
            'monthly' => Salon::where('subscription_type', 'monthly')->count(),
            'yearly' => Salon::where('subscription_type', 'yearly')->count(),
        ];

        // Recent payments
        $recentPayments = Payment::with(['salon', 'salesUser'])
            ->latest()
            ->limit(10)
            ->get();

        // Salons with payment info
        $salons = Salon::with(['salesUser', 'payments' => function ($q) {
                $q->paid()->latest();
            }])
            ->get()
            ->map(function ($salon) {
                $salon->total_paid = $salon->payments->sum('amount');
                $salon->last_payment_date = $salon->payments->first()?->created_at;
                return $salon;
            });

        return view('superAdmin.dashboard', [
            'totalSalons' => $totalSalons,
            'activeSalons' => $activeSalons,
            'trialSalons' => $trialSalons,
            'paidSalons' => $paidSalons,
            'totalIncome' => $totalIncome,
            'monthlySubIncome' => $monthlySubIncome,
            'yearlySubIncome' => $yearlySubIncome,
            'totalCommissionsPaid' => $totalCommissionsPaid,
            'thisMonthIncome' => $thisMonthIncome,
            'monthlyIncome' => $monthlyIncome,
            'subscriptionStats' => $subscriptionStats,
            'overdueSalons' => $overdueSalons,
            'expiringSoon' => $expiringSoon,
            'salesUsers' => $salesUsers,
            'recentPayments' => $recentPayments,
            'salons' => $salons,
        ]);
    }

    /**
     * Record a subscription payment for a salon
     */
    public function recordPayment(Request $request, Salon $salon)
    {
        $request->validate([
            'subscription_type' => 'required|in:monthly,yearly',
            'notes' => 'nullable|string|max:500',
        ]);

        Payment::recordPayment($salon, $request->subscription_type, $request->notes);

        return back()->with('success', __('admin.payment_recorded_successfully'));
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
            }, 'salesUser', 'user'])
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
        
        // Get all sales users for assignment
        $salesUsers = User::where('role', 'sales')->get();

        return view('superAdmin.salons.create', compact('users', 'salesUsers'));
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
            'sales_user_id' => 'nullable|exists:users,id',
        ]);

        $trial_end_date = now()->addDays(14);

        // Create salon
        $salon = new Salon($validated);

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

        return redirect()->route('superAdmin.salons.index')
            ->with('success', __('messages.sa_salon_created'));
    }

    /**
     * Show salon details
     */
    public function showSalon(Salon $salon)
    {
        $salon->load(['bookings', 'products', 'services', 'staff', 'clients', 'salesUser', 'user',
            'payments' => function ($q) {
                $q->with('salesUser')->latest();
            }
        ]);
        
        $total_bookings = $salon->bookings->count();
        $completed_bookings = $salon->bookings->where('status', 'completed')->count();
        $revenue = $salon->bookings->where('status', 'completed')->sum('price');
        $totalPaid = $salon->payments->where('status', 'paid')->sum('amount');
        $totalCommission = $salon->payments->where('status', 'paid')->sum('commission_amount');

        return view('superAdmin.salons.show', [
            'salon' => $salon,
            'total_bookings' => $total_bookings,
            'completed_bookings' => $completed_bookings,
            'revenue' => $revenue,
            'totalPaid' => $totalPaid,
            'totalCommission' => $totalCommission,
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
            ->with('success', __('messages.sa_salon_deleted'));
    }

    /**
     * Toggle salon owner account active/blocked status
     */
    public function toggleSalonStatus(Salon $salon)
    {
        $owner = $salon->user;
        
        if (!$owner) {
            return back()->with('error', __('admin.salon_has_no_owner'));
        }

        $owner->update(['is_active' => !$owner->is_active]);

        // If reactivating, also check and re-enable based on subscription
        $status = $owner->is_active ? __('admin.account_activated') : __('admin.account_blocked');

        return back()->with('success', $status);
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
     * Show product details
     */
    public function showProduct(Product $product)
    {
        $product->load('salon');
        return view('superAdmin.products.show', compact('product'));
    }

    /**
     * Show edit product form
     */
    public function editProduct(Product $product)
    {
        $product->load('salon');
        return view('superAdmin.products.edit', compact('product'));
    }

    /**
     * Update product information
     */
    public function updateProduct(Request $request, Product $product)
    {
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
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('superAdmin.products.show', $product->id)
            ->with('success', __('messages.sa_product_updated'));
    }

    /**
     * Delete a product
     */
    public function destroyProduct(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('superAdmin.products.index')
            ->with('success', __('messages.sa_product_deleted'));
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
            ->with('success', __('messages.sa_booking_deleted'));
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

    /**
     * List all sales users
     */
    public function salesUsers()
    {
        $salesUsers = User::where('role', 'sales')
            ->withCount('soldSalons')
            ->get()
            ->map(function ($user) {
                $user->total_commission = $user->totalCommissionEarned();
                return $user;
            });

        return view('superAdmin.salesUsers.index', compact('salesUsers'));
    }

    /**
     * Show create sales user form
     */
    public function createSalesUser()
    {
        return view('superAdmin.salesUsers.create');
    }

    /**
     * Store a new sales user
     */
    public function storeSalesUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'sales',
            'commission_rate' => $validated['commission_rate'],
        ]);

        return redirect()->route('superAdmin.salesUsers.index')
            ->with('success', __('admin.sales_user_created'));
    }

    /**
     * Show edit sales user form
     */
    public function editSalesUser(User $user)
    {
        if ($user->role !== 'sales') abort(404);
        $salesUser = $user;
        return view('superAdmin.salesUsers.edit', compact('salesUser'));
    }

    /**
     * Update a sales user
     */
    public function updateSalesUser(Request $request, User $user)
    {
        if ($user->role !== 'sales') abort(404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->commission_rate = $validated['commission_rate'];
        
        if (!empty($validated['password'])) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }
        
        $user->save();

        return redirect()->route('superAdmin.salesUsers.index')
            ->with('success', __('admin.sales_user_updated'));
    }

    /**
     * Delete a sales user
     */
    public function destroySalesUser(User $user)
    {
        if ($user->role !== 'sales') abort(404);
        
        // Unlink salons from this sales user
        Salon::where('sales_user_id', $user->id)->update(['sales_user_id' => null]);
        $user->delete();

        return redirect()->route('superAdmin.salesUsers.index')
            ->with('success', __('admin.sales_user_deleted'));
    }
}
