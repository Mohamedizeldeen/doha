<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
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

        // Get weekly revenue data
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
            'totalClients' => $totalClients,
            'totalServices' => $totalServices,
            'totalStaff' => $totalStaff,
            'totalProducts' => $totalProducts,
        ]);
    }
}
