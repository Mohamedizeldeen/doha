<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $expenses = Expense::where('salon_id', $salon->id)
            ->orderByDesc('expense_date')
            ->paginate(20);

        $monthlyTotal = Expense::where('salon_id', $salon->id)
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount');

        return view('expenses.index', compact('salon', 'expenses', 'monthlyTotal'));
    }

    public function create(Salon $salon)
    {
        $this->authorize('own', $salon);
        $categories = Expense::categories();
        return view('expenses.create', compact('salon', 'categories'));
    }

    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'category' => 'required|in:supplier,rent,salary,utilities,marketing,maintenance,equipment,insurance,other',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'supplier_name' => 'nullable|string|max:255',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('receipt_image')) {
            $validated['receipt_image'] = $request->file('receipt_image')->store(
                "expenses/salon-{$salon->id}", 'public'
            );
        }

        Expense::create(array_merge($validated, ['salon_id' => $salon->id]));

        return redirect()->route('expense.index', $salon)
            ->with('success', __('admin.expense_created'));
    }

    public function destroy(Salon $salon, Expense $expense)
    {
        $this->authorize('own', $salon);
        if ($expense->salon_id !== $salon->id) abort(403);

        if ($expense->receipt_image && Storage::disk('public')->exists($expense->receipt_image)) {
            Storage::disk('public')->delete($expense->receipt_image);
        }

        $expense->delete();

        return redirect()->route('expense.index', $salon)
            ->with('success', __('admin.expense_deleted'));
    }
}
