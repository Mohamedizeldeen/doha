<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Book;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $salon = $user->salon;

        if (!$salon) {
            return redirect()->route('login')->withErrors(['email' => __('admin.no_salon_assigned')]);
        }

        $staffId = $user->staff_id;

        $todayBookings = Book::where('salon_id', $salon->id)
            ->where('staff_id', $staffId)
            ->whereDate('appointment_datetime', today())
            ->count();

        $pendingBookings = Book::where('salon_id', $salon->id)
            ->where('staff_id', $staffId)
            ->where('status', 'pending')
            ->count();

        $completedToday = Book::where('salon_id', $salon->id)
            ->where('staff_id', $staffId)
            ->whereDate('appointment_datetime', today())
            ->where('status', 'completed')
            ->count();

        $totalCompleted = Book::where('salon_id', $salon->id)
            ->where('staff_id', $staffId)
            ->where('status', 'completed')
            ->count();

        $todayBookingsList = Book::where('salon_id', $salon->id)
            ->where('staff_id', $staffId)
            ->whereDate('appointment_datetime', today())
            ->with(['client', 'service'])
            ->orderBy('appointment_datetime')
            ->get();

        return view('employee.dashboard', compact(
            'salon', 'todayBookings', 'pendingBookings',
            'completedToday', 'totalCompleted', 'todayBookingsList'
        ));
    }
}
