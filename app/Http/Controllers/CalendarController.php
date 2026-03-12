<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Book;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function daily(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $date = $request->get('date', now()->toDateString());
        $currentDate = Carbon::parse($date);

        $bookings = $salon->bookings()
            ->with(['client', 'service', 'staff'])
            ->whereDate('appointment_datetime', $currentDate)
            ->orderBy('appointment_datetime')
            ->get();

        $staff = $salon->staff()->where('is_active', true)->get();

        // Group bookings by staff
        $staffBookings = [];
        foreach ($staff as $member) {
            $staffBookings[$member->id] = [
                'staff' => $member,
                'bookings' => $bookings->where('staff_id', $member->id)->values(),
            ];
        }

        // Unassigned bookings
        $unassigned = $bookings->whereNull('staff_id')->values();

        return view('calendar.daily', compact('salon', 'currentDate', 'bookings', 'staff', 'staffBookings', 'unassigned'));
    }

    public function weekly(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $date = $request->get('date', now()->toDateString());
        $startOfWeek = Carbon::parse($date)->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        $bookings = $salon->bookings()
            ->with(['client', 'service', 'staff'])
            ->whereBetween('appointment_datetime', [$startOfWeek, $endOfWeek])
            ->orderBy('appointment_datetime')
            ->get();

        $staff = $salon->staff()->where('is_active', true)->get();

        // Group bookings by day
        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $weekDays[] = [
                'date' => $day,
                'bookings' => $bookings->filter(function ($b) use ($day) {
                    return $b->appointment_datetime->toDateString() === $day->toDateString();
                })->values(),
            ];
        }

        return view('calendar.weekly', compact('salon', 'startOfWeek', 'endOfWeek', 'weekDays', 'staff', 'bookings'));
    }
}
