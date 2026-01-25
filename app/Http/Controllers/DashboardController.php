<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the first salon of the authenticated user
        $salon = Auth::user()->salons->first();
        
        if (!$salon) {
            return redirect()->route('salon.index');
        }

        // Get current week dates
        $startOfWeek = now()->startOfWeek(Carbon::SATURDAY);
        $endOfWeek = now()->endOfWeek(Carbon::FRIDAY);

        // Get booking statistics
        $totalBookings = Book::where('salon_id', $salon->id)->count();
        $confirmedBookings = Book::where('salon_id', $salon->id)
            ->where('status', 'completed')
            ->count();
        $pendingBookings = Book::where('salon_id', $salon->id)
            ->where('status', 'scheduled')
            ->count();
        $cancelledBookings = Book::where('salon_id', $salon->id)
            ->where('status', 'canceled')
            ->count();

        // Get weekly revenue data (per day) and totals
        $weeklyRevenue = [];
        $dayLabels = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $dayLabels[] = $date->format('l');

            $revenue = Book::where('salon_id', $salon->id)
                ->whereDate('appointment_datetime', $date->toDateString())
                ->where('status', 'completed')
                ->sum('price');

            $weeklyRevenue[] = $revenue ?? 0;
        }
        $weeklyTotal = array_sum($weeklyRevenue);

        // Monthly and yearly totals (for current month/year)
        $now = now();
        $monthlyTotal = Book::where('salon_id', $salon->id)
            ->whereMonth('appointment_datetime', $now->month)
            ->whereYear('appointment_datetime', $now->year)
            ->where('status', 'completed')
            ->sum('price');

        $yearlyTotal = Book::where('salon_id', $salon->id)
            ->whereYear('appointment_datetime', $now->year)
            ->where('status', 'completed')
            ->sum('price');

        // Get monthly breakdown for current year (for chart)
        $monthlyData = [];
        $monthLabels = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthLabels[] = Carbon::createFromDate($now->year, $m, 1)->format('M');
            $revenue = Book::where('salon_id', $salon->id)
                ->whereMonth('appointment_datetime', $m)
                ->whereYear('appointment_datetime', $now->year)
                ->where('status', 'completed')
                ->sum('price');
            $monthlyData[] = $revenue ?? 0;
        }

        // Get statistics
        $totalClients = Client::where('salon_id', $salon->id)->count();
        $totalServices = Service::where('salon_id', $salon->id)->count();
        $totalStaff = Staff::where('salon_id', $salon->id)->count();
        $totalProducts = Product::where('salon_id', $salon->id)->count();

        return view('admin.dashboard', [
            'salon' => $salon,
            'totalBookings' => $totalBookings,
            'confirmedBookings' => $confirmedBookings,
            'pendingBookings' => $pendingBookings,
            'cancelledBookings' => $cancelledBookings,
            'weeklyRevenue' => $weeklyRevenue,
            'dayLabels' => $dayLabels,
            'weeklyTotal' => $weeklyTotal,
            'monthlyTotal' => $monthlyTotal,
            'yearlyTotal' => $yearlyTotal,
            'monthlyData' => $monthlyData,
            'monthLabels' => $monthLabels,
            'totalClients' => $totalClients,
            'totalServices' => $totalServices,
            'totalStaff' => $totalStaff,
            'totalProducts' => $totalProducts,
        ]);
    }

    /**
     * Filter revenue via AJAX (no page reload)
     */
    public function filterRevenue(Request $request)
    {
        $salon = Auth::user()->salons->first();
        
        if (!$salon) {
            return response()->json(['error' => 'Salon not found'], 404);
        }

        $filteredRevenue = null;
        $filterLabel = null;
        $filteredChartData = null;
        $filteredChartLabels = null;
        $now = now();

        if ($request->filled('date')) {
            try {
                $d = Carbon::parse($request->input('date'));
                $filteredRevenue = Book::where('salon_id', $salon->id)
                    ->whereDate('appointment_datetime', $d->toDateString())
                    ->where('status', 'completed')
                    ->sum('price');
                $filterLabel = $d->toFormattedDateString();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid date'], 400);
            }
        } elseif ($request->filled('month')) {
            try {
                $m = Carbon::createFromFormat('Y-m', $request->input('month'));
                $filteredRevenue = Book::where('salon_id', $salon->id)
                    ->whereMonth('appointment_datetime', $m->month)
                    ->whereYear('appointment_datetime', $m->year)
                    ->where('status', 'completed')
                    ->sum('price');
                $filterLabel = $m->format('F Y');

                // Get daily breakdown for chart
                $daysInMonth = $m->daysInMonth;
                $filteredChartData = [];
                $filteredChartLabels = [];
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $date = Carbon::createFromDate($m->year, $m->month, $d);
                    $filteredChartLabels[] = 'Day ' . $d;
                    $revenue = Book::where('salon_id', $salon->id)
                        ->whereDate('appointment_datetime', $date->toDateString())
                        ->where('status', 'completed')
                        ->sum('price');
                    $filteredChartData[] = $revenue ?? 0;
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid month'], 400);
            }
        } elseif ($request->filled('year')) {
            $y = intval($request->input('year')) ?: $now->year;
            $filteredRevenue = Book::where('salon_id', $salon->id)
                ->whereYear('appointment_datetime', $y)
                ->where('status', 'completed')
                ->sum('price');
            $filterLabel = $y;
        }

        return response()->json([
            'filteredRevenue' => $filteredRevenue,
            'filterLabel' => $filterLabel,
            'filteredChartData' => $filteredChartData,
            'filteredChartLabels' => $filteredChartLabels,
        ]);
    }
}
