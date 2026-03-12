<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Invoice;
use App\Models\Expense;
use App\Models\SalaryPayment;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialReportController extends Controller
{
    /**
     * Monthly Net Profit Report
     */
    public function netProfit(Salon $salon)
    {
        $this->authorize('own', $salon);

        $currency = $salon->currency ?? 'OMR';
        $month = request('month', now()->format('Y-m'));
        $monthStart = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $monthEnd = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        // Revenue
        $totalRevenue = Invoice::where('salon_id', $salon->id)
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->where('status', '!=', 'refunded')
            ->sum('paid_amount');

        // Expenses by category
        $expenses = Expense::where('salon_id', $salon->id)
            ->whereBetween('expense_date', [$monthStart, $monthEnd])
            ->get();

        $expensesByCategory = $expenses->groupBy('category')->map(fn($items) => $items->sum('amount'));
        $totalExpenses = $expenses->sum('amount');

        // Salaries
        $totalSalaries = SalaryPayment::where('salon_id', $salon->id)
            ->where('month', $month)
            ->where('status', 'paid')
            ->sum('total_amount');

        // Net profit
        $netProfit = $totalRevenue - $totalExpenses - $totalSalaries;
        $profitMargin = $totalRevenue > 0 ? round(($netProfit / $totalRevenue) * 100, 1) : 0;

        // Monthly trend (last 6 months)
        $monthlyTrend = collect();
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $mStart = $m->copy()->startOfMonth();
            $mEnd = $m->copy()->endOfMonth();
            $mKey = $m->format('Y-m');

            $rev = Invoice::where('salon_id', $salon->id)
                ->whereBetween('created_at', [$mStart, $mEnd])
                ->where('status', '!=', 'refunded')
                ->sum('paid_amount');

            $exp = Expense::where('salon_id', $salon->id)
                ->whereBetween('expense_date', [$mStart, $mEnd])
                ->sum('amount');

            $sal = SalaryPayment::where('salon_id', $salon->id)
                ->where('month', $mKey)
                ->where('status', 'paid')
                ->sum('total_amount');

            $monthlyTrend->push((object) [
                'month' => $mKey,
                'label' => $m->format('M Y'),
                'revenue' => $rev,
                'expenses' => $exp + $sal,
                'profit' => $rev - $exp - $sal,
            ]);
        }

        return view('reports.net-profit', compact(
            'salon', 'currency', 'month', 'totalRevenue', 'totalExpenses',
            'totalSalaries', 'netProfit', 'profitMargin', 'expensesByCategory',
            'monthlyTrend'
        ));
    }

    /**
     * VAT Tax Report
     */
    public function vatReport(Salon $salon)
    {
        $this->authorize('own', $salon);

        $currency = $salon->currency ?? 'OMR';
        $month = request('month', now()->format('Y-m'));
        $monthStart = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $monthEnd = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        // VAT on invoices (output VAT)
        $invoices = Invoice::where('salon_id', $salon->id)
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->where('status', '!=', 'refunded')
            ->get();

        $totalSales = $invoices->sum('subtotal');
        $outputVat = $invoices->sum('tax_amount');
        $totalWithVat = $invoices->sum('total');

        // VAT on expenses (input VAT)
        $expensesWithVat = Expense::where('salon_id', $salon->id)
            ->whereBetween('expense_date', [$monthStart, $monthEnd])
            ->where('vat_amount', '>', 0)
            ->get();

        $inputVat = $expensesWithVat->sum('vat_amount');
        $netVat = $outputVat - $inputVat;

        // Quarterly summary
        $quarter = ceil($monthStart->month / 3);
        $quarterStart = Carbon::create($monthStart->year, ($quarter - 1) * 3 + 1, 1)->startOfMonth();
        $quarterEnd = $quarterStart->copy()->addMonths(3)->subDay()->endOfDay();

        $quarterInvoices = Invoice::where('salon_id', $salon->id)
            ->whereBetween('created_at', [$quarterStart, $quarterEnd])
            ->where('status', '!=', 'refunded')
            ->get();

        $quarterOutputVat = $quarterInvoices->sum('tax_amount');
        $quarterInputVat = Expense::where('salon_id', $salon->id)
            ->whereBetween('expense_date', [$quarterStart, $quarterEnd])
            ->sum('vat_amount');
        $quarterNetVat = $quarterOutputVat - $quarterInputVat;

        return view('reports.vat-report', compact(
            'salon', 'currency', 'month', 'totalSales', 'outputVat', 'totalWithVat',
            'inputVat', 'netVat', 'expensesWithVat', 'quarter', 'quarterOutputVat',
            'quarterInputVat', 'quarterNetVat', 'invoices'
        ));
    }

    /**
     * Revenue Comparison Month over Month
     */
    public function revenueComparison(Salon $salon)
    {
        $this->authorize('own', $salon);

        $currency = $salon->currency ?? 'OMR';
        $months = (int) request('months', 6);

        $comparison = collect();
        for ($i = $months - 1; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $mStart = $m->copy()->startOfMonth();
            $mEnd = $m->copy()->endOfMonth();

            $revenue = Invoice::where('salon_id', $salon->id)
                ->whereBetween('created_at', [$mStart, $mEnd])
                ->where('status', '!=', 'refunded')
                ->sum('paid_amount');

            $invoiceCount = Invoice::where('salon_id', $salon->id)
                ->whereBetween('created_at', [$mStart, $mEnd])
                ->count();

            $bookingCount = Book::where('salon_id', $salon->id)
                ->whereBetween('appointment_datetime', [$mStart, $mEnd])
                ->count();

            $completedCount = Book::where('salon_id', $salon->id)
                ->whereBetween('appointment_datetime', [$mStart, $mEnd])
                ->where('status', 'completed')
                ->count();

            $expenses = Expense::where('salon_id', $salon->id)
                ->whereBetween('expense_date', [$mStart, $mEnd])
                ->sum('amount');

            $comparison->push((object) [
                'month' => $m->format('Y-m'),
                'label' => $m->translatedFormat('M Y'),
                'revenue' => $revenue,
                'expenses' => $expenses,
                'profit' => $revenue - $expenses,
                'invoices' => $invoiceCount,
                'bookings' => $bookingCount,
                'completed' => $completedCount,
                'avg_ticket' => $invoiceCount > 0 ? round($revenue / $invoiceCount, 2) : 0,
            ]);
        }

        // Growth rates
        $comparison->each(function ($item, $key) use ($comparison) {
            if ($key > 0) {
                $prev = $comparison[$key - 1];
                $item->revenue_growth = $prev->revenue > 0
                    ? round((($item->revenue - $prev->revenue) / $prev->revenue) * 100, 1)
                    : ($item->revenue > 0 ? 100 : 0);
                $item->booking_growth = $prev->bookings > 0
                    ? round((($item->bookings - $prev->bookings) / $prev->bookings) * 100, 1)
                    : ($item->bookings > 0 ? 100 : 0);
            } else {
                $item->revenue_growth = 0;
                $item->booking_growth = 0;
            }
        });

        return view('reports.revenue-comparison', compact('salon', 'currency', 'comparison', 'months'));
    }
}
