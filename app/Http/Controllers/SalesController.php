<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Book;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
{
    /**
     * Sales dashboard - shows overview of salons created by this sales person
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $soldSalons = Salon::where('sales_user_id', $user->id)
            ->withCount('bookings')
            ->with(['payments' => function ($q) {
                $q->paid();
            }])
            ->get()
            ->map(function ($salon) {
                $salon->total_paid = $salon->payments->sum('amount');
                $salon->salon_commission = $salon->payments->sum('commission_amount');
                return $salon;
            });

        $totalSalons = $soldSalons->count();
        $commissionRate = $user->commission_rate;
        $totalCommission = $user->totalCommissionEarned();
        $totalSubscriptionIncome = $soldSalons->sum('total_paid');
        
        // Active vs expired subscriptions
        $activeSalons = $soldSalons->filter(fn($s) => $s->isSubscriptionActive())->count();
        
        // Salons expiring within 7 days
        $expiringSoon = $soldSalons->filter(function ($salon) {
            return $salon->isSubscriptionActive() && $salon->daysRemaining() <= 7;
        });

        // Monthly commission data from payments
        $monthlyCommission = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthCommission = Payment::where('sales_user_id', $user->id)
                ->paid()
                ->whereMonth('created_at', $m)
                ->whereYear('created_at', now()->year)
                ->sum('commission_amount');
            $monthlyCommission[] = round($monthCommission, 2);
        }

        // Recent payments for this sales user
        $recentPayments = Payment::where('sales_user_id', $user->id)
            ->paid()
            ->with('salon')
            ->latest()
            ->limit(5)
            ->get();

        return view('sales.dashboard', compact(
            'soldSalons', 'totalSalons', 'commissionRate',
            'totalCommission', 'totalSubscriptionIncome', 'activeSalons', 'expiringSoon',
            'monthlyCommission', 'recentPayments'
        ));
    }

    /**
     * List all salons created by this sales person
     */
    public function salons()
    {
        $salons = Salon::where('sales_user_id', Auth::id())
            ->withCount('bookings')
            ->withCount('services')
            ->withCount('staff')
            ->withCount('clients')
            ->with(['payments' => fn($q) => $q->paid()])
            ->latest()
            ->paginate(15);

        $salons->each(function ($salon) {
            $salon->total_paid = $salon->payments->sum('amount');
            $salon->salon_commission = $salon->payments->sum('commission_amount');
        });

        return view('sales.salons.index', compact('salons'));
    }

    /**
     * Show form to create a new salon (sales can also create salons)
     */
    public function createSalon()
    {
        return view('sales.salons.create');
    }

    /**
     * Store a new salon created by the sales person
     */
    public function storeSalon(Request $request)
    {
        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'owner_phone' => 'nullable|string|max:20',
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'nullable|string|max:500',
            'address_ar' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'salon_email' => 'nullable|email|max:255',
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

        // Auto-create admin user for the salon owner
        $owner = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'phone' => $validated['owner_phone'] ?? null,
        ]);

        $salon = new Salon();
        $salon->user_id = $owner->id;
        $salon->sales_user_id = Auth::id();
        $salon->name_ar = $validated['name_ar'];
        $salon->name_en = $validated['name_en'] ?? null;
        $salon->address_ar = $validated['address_ar'] ?? null;
        $salon->address_en = $validated['address_en'] ?? null;
        $salon->phone = $validated['phone'] ?? null;
        $salon->email = $validated['salon_email'] ?? null;
        $salon->description_ar = $validated['description_ar'] ?? null;
        $salon->description_en = $validated['description_en'] ?? null;
        $salon->subscription_type = $validated['subscription_type'];
        $salon->opening_time = $validated['opening_time'] ?? '09:00';
        $salon->closing_time = $validated['closing_time'] ?? '21:00';
        $salon->currency = $validated['currency'] ?? 'OMR';

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $salon->logo = $path;
        }

        if (isset($validated['work_days']) && !empty($validated['work_days'])) {
            $salon->work_days = json_encode($validated['work_days']);
        }

        $salon->setSubscriptionDates();
        $salon->save();

        return redirect()->route('sales.salons.index')
            ->with('success', __('admin.salon_created_successfully'));
    }

    /**
     * Show a specific salon's details
     */
    public function showSalon(Salon $salon)
    {
        // Ensure this salon belongs to this sales person
        if ($salon->sales_user_id !== Auth::id()) {
            abort(403);
        }

        $salon->load(['bookings', 'services', 'staff', 'clients', 'payments' => function ($q) {
            $q->paid()->latest();
        }]);

        $total_bookings = $salon->bookings->count();
        $completed_bookings = $salon->bookings->where('status', 'completed')->count();
        $totalPaid = $salon->payments->sum('amount');
        $totalCommission = $salon->payments->sum('commission_amount');
        $payments = $salon->payments;

        return view('sales.salons.show', compact(
            'salon', 'total_bookings', 'completed_bookings',
            'totalPaid', 'totalCommission', 'payments'
        ));
    }
}
