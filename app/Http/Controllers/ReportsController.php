<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Book;
use App\Models\Service;
use App\Models\Client;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(Salon $salon)
    {
        // Authorize: user must own this salon
        if ($salon->user_id !== auth()->id()) {
            abort(403);
        }

        $currency = $salon->currency ?? 'OMR';

        // ── Summary Stats ──────────────────────────────────────
        $totalBookings   = Book::where('salon_id', $salon->id)->count();
        $completedBookings = Book::where('salon_id', $salon->id)->where('status', 'completed')->count();
        $totalRevenue    = Book::where('salon_id', $salon->id)->where('status', 'completed')->sum('price');
        $avgBookingValue = $completedBookings > 0 ? round($totalRevenue / $completedBookings, 2) : 0;
        $totalClients    = Client::where('salon_id', $salon->id)->count();
        $totalServices   = Service::where('salon_id', $salon->id)->count();

        // ── Revenue by Service (top 10) ───────────────────────
        $revenueByService = Book::where('books.salon_id', $salon->id)
            ->where('books.status', 'completed')
            ->join('services', 'books.service_id', '=', 'services.id')
            ->select(
                'services.id',
                'services.name_en',
                'services.name_ar',
                DB::raw('SUM(books.price) as total_revenue'),
                DB::raw('COUNT(books.id) as bookings_count')
            )
            ->groupBy('services.id', 'services.name_en', 'services.name_ar')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // ── Bookings Over Last 30 Days ────────────────────────
        $bookingsOverTime = Book::where('salon_id', $salon->id)
            ->where('appointment_datetime', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(appointment_datetime) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN status = \'completed\' THEN price ELSE 0 END) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ── Top 10 Clients by Revenue ─────────────────────────
        $topClients = Book::where('books.salon_id', $salon->id)
            ->where('books.status', 'completed')
            ->join('clients', 'books.client_id', '=', 'clients.id')
            ->select(
                'clients.id',
                'clients.name_en',
                'clients.name_ar',
                'clients.phone',
                DB::raw('SUM(books.price) as total_spent'),
                DB::raw('COUNT(books.id) as visits')
            )
            ->groupBy('clients.id', 'clients.name_en', 'clients.name_ar', 'clients.phone')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // ── Staff Performance ─────────────────────────────────
        $staffPerformance = Book::where('books.salon_id', $salon->id)
            ->where('books.status', 'completed')
            ->join('staff', 'books.staff_id', '=', 'staff.id')
            ->select(
                'staff.id',
                'staff.name_en',
                'staff.name_ar',
                DB::raw('SUM(books.price) as total_revenue'),
                DB::raw('COUNT(books.id) as bookings_count')
            )
            ->groupBy('staff.id', 'staff.name_en', 'staff.name_ar')
            ->orderByDesc('total_revenue')
            ->get();

        // ── Busiest Day of Week ───────────────────────────────
        $busiestDay = Book::where('salon_id', $salon->id)
            ->select(
                DB::raw('DAYNAME(appointment_datetime) as day_name'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('day_name')
            ->orderByDesc('count')
            ->first();

        // ── Monthly Revenue Trend (last 12 months) ────────────
        $monthlyRevenue = Book::where('salon_id', $salon->id)
            ->where('status', 'completed')
            ->where('appointment_datetime', '>=', Carbon::now()->subMonths(12))
            ->select(
                DB::raw('DATE_FORMAT(appointment_datetime, \'%Y-%m\') as month'),
                DB::raw('SUM(price) as revenue'),
                DB::raw('COUNT(*) as bookings')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports', compact(
            'salon',
            'currency',
            'totalBookings',
            'completedBookings',
            'totalRevenue',
            'avgBookingValue',
            'totalClients',
            'totalServices',
            'revenueByService',
            'bookingsOverTime',
            'topClients',
            'staffPerformance',
            'busiestDay',
            'monthlyRevenue'
        ));
    }
}
