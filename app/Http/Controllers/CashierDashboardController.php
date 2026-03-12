<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Invoice;
use App\Models\Book;
use Illuminate\Http\Request;

class CashierDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $salon = $user->salon;

        if (!$salon) {
            return redirect()->route('login')->withErrors(['email' => __('admin.no_salon_assigned')]);
        }

        $todayRevenue = Invoice::where('salon_id', $salon->id)
            ->whereDate('created_at', today())
            ->where('status', '!=', 'refunded')
            ->sum('paid_amount');

        $todayInvoices = Invoice::where('salon_id', $salon->id)
            ->whereDate('created_at', today())
            ->count();

        $todayCash = Invoice::where('salon_id', $salon->id)
            ->whereDate('created_at', today())
            ->where('payment_method', 'cash')
            ->sum('paid_amount');

        $todayCard = Invoice::where('salon_id', $salon->id)
            ->whereDate('created_at', today())
            ->where('payment_method', 'card')
            ->sum('paid_amount');

        // Pending bookings that need invoicing
        $pendingBookings = Book::where('salon_id', $salon->id)
            ->where('status', 'completed')
            ->whereDoesntHave('invoice')
            ->with(['client', 'service', 'staff'])
            ->orderBy('appointment_datetime', 'desc')
            ->take(10)
            ->get();

        $recentInvoices = Invoice::where('salon_id', $salon->id)
            ->whereDate('created_at', today())
            ->with('client')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('cashier.dashboard', compact(
            'salon', 'todayRevenue', 'todayInvoices',
            'todayCash', 'todayCard', 'pendingBookings', 'recentInvoices'
        ));
    }
}
