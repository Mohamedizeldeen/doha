<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Staff;
use App\Models\StaffSchedule;
use App\Models\StaffLeave;
use Illuminate\Http\Request;

class StaffScheduleController extends Controller
{
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $staffMembers = Staff::where('salon_id', $salon->id)->get();
        $schedules = StaffSchedule::where('salon_id', $salon->id)->orderBy('day_of_week')->get();
        $leaves = StaffLeave::where('salon_id', $salon->id)->orderByDesc('start_date')->get();

        return view('staff.schedule', compact('salon', 'staffMembers', 'schedules', 'leaves'));
    }

    public function updateSchedule(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'days' => 'nullable|array',
            'days.*.enabled' => 'nullable',
            'days.*.start_time' => 'nullable|date_format:H:i',
            'days.*.end_time' => 'nullable|date_format:H:i',
        ]);

        $staff = Staff::where('id', $validated['staff_id'])->where('salon_id', $salon->id)->firstOrFail();

        // Delete existing schedules and recreate
        $staff->schedules()->delete();

        if (!empty($validated['days'])) {
            foreach ($validated['days'] as $dayNum => $day) {
                StaffSchedule::create([
                    'staff_id' => $staff->id,
                    'salon_id' => $salon->id,
                    'day_of_week' => $dayNum,
                    'start_time' => $day['start_time'] ?? '09:00',
                    'end_time' => $day['end_time'] ?? '18:00',
                    'is_day_off' => empty($day['enabled']),
                ]);
            }
        }

        return back()->with('success', __('admin.save'));
    }

    public function storeLeave(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:500',
        ]);

        $staff = Staff::where('id', $validated['staff_id'])->where('salon_id', $salon->id)->firstOrFail();

        StaffLeave::create([
            'staff_id' => $staff->id,
            'salon_id' => $salon->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'] ?? null,
            'status' => 'approved',
        ]);

        return back()->with('success', __('admin.save'));
    }

    public function destroyLeave(Salon $salon, StaffLeave $leave)
    {
        $this->authorize('own', $salon);
        if ($leave->salon_id !== $salon->id) abort(403);

        $leave->delete();

        return back()->with('success', __('admin.save'));
    }
}
