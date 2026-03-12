<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Staff;
use App\Models\SalaryPayment;
use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $month = request('month', now()->format('Y-m'));
        $currency = $salon->currency ?? 'OMR';

        $staffMembers = Staff::where('salon_id', $salon->id)
            ->where('is_active', true)
            ->get();

        // Calculate commission for each staff for the month
        $staffSalaries = $staffMembers->map(function ($staff) use ($salon, $month) {
            $monthStart = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $monthEnd = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

            $monthRevenue = Book::where('salon_id', $salon->id)
                ->where('staff_id', $staff->id)
                ->where('status', 'completed')
                ->whereBetween('appointment_datetime', [$monthStart, $monthEnd])
                ->sum('price');

            $commission = $staff->calculateCommission($monthRevenue);

            $existingPayment = SalaryPayment::where('salon_id', $salon->id)
                ->where('staff_id', $staff->id)
                ->where('month', $month)
                ->first();

            return (object) [
                'staff' => $staff,
                'base_salary' => $staff->salary ?? 0,
                'month_revenue' => $monthRevenue,
                'commission' => $commission,
                'payment' => $existingPayment,
                'total' => ($staff->salary ?? 0) + $commission + ($existingPayment->bonus ?? 0) - ($existingPayment->deductions ?? 0),
            ];
        });

        $totalSalaries = $staffSalaries->sum('total');
        $totalPaid = $staffSalaries->filter(fn($s) => $s->payment && $s->payment->status === 'paid')->sum('total');

        return view('salaries.index', compact('salon', 'staffSalaries', 'month', 'currency', 'totalSalaries', 'totalPaid'));
    }

    public function store(Request $request, Salon $salon)
    {
        $this->authorize('update', $salon);

        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'month' => 'required|date_format:Y-m',
            'base_salary' => 'required|numeric|min:0',
            'commission_amount' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $total = $validated['base_salary'] + $validated['commission_amount'] + ($validated['bonus'] ?? 0) - ($validated['deductions'] ?? 0);

        SalaryPayment::updateOrCreate(
            [
                'salon_id' => $salon->id,
                'staff_id' => $validated['staff_id'],
                'month' => $validated['month'],
            ],
            [
                'base_salary' => $validated['base_salary'],
                'commission_amount' => $validated['commission_amount'],
                'bonus' => $validated['bonus'] ?? 0,
                'deductions' => $validated['deductions'] ?? 0,
                'total_amount' => $total,
                'status' => 'paid',
                'paid_date' => now()->toDateString(),
                'notes' => $validated['notes'],
            ]
        );

        return redirect()->route('salary.index', ['salon' => $salon, 'month' => $validated['month']])
            ->with('success', __('admin.salary_paid'));
    }
}
