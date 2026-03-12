<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Client;
use App\Models\Service;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Book;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $invoices = Invoice::where('salon_id', $salon->id)
            ->with('client')
            ->orderByDesc('created_at')
            ->paginate(20);

        $todayRevenue = Invoice::where('salon_id', $salon->id)
            ->whereDate('created_at', today())
            ->where('status', '!=', 'refunded')
            ->sum('paid_amount');

        // Dashboard stats
        $totalInvoices = Invoice::where('salon_id', $salon->id)->count();
        $totalRevenue = Invoice::where('salon_id', $salon->id)->where('status', '!=', 'refunded')->sum('paid_amount');
        $unpaidAmount = Invoice::where('salon_id', $salon->id)->where('status', 'unpaid')->sum('total');
        $partialAmount = Invoice::where('salon_id', $salon->id)->where('status', 'partial')->sum('remaining_amount');
        $monthlyRevenue = Invoice::where('salon_id', $salon->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'refunded')
            ->sum('paid_amount');

        return view('invoices.index', compact(
            'salon', 'invoices', 'todayRevenue',
            'totalInvoices', 'totalRevenue', 'unpaidAmount', 'partialAmount', 'monthlyRevenue'
        ));
    }

    public function create(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $clients = $salon->clients()->get();
        $services = $salon->services()->where('is_active', true)->get();
        $products = $salon->products()->where('stock_quantity', '>', 0)->get();
        $bookingId = $request->get('booking_id');
        $booking = $bookingId ? Book::with(['client', 'service'])->find($bookingId) : null;

        return view('invoices.create', compact('salon', 'clients', 'services', 'products', 'booking'));
    }

    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'booking_id' => 'nullable|exists:books,id',
            'payment_method' => 'required|in:cash,card,wallet,partial',
            'paid_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'coupon_code' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:service,product',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Calculate totals
        $subtotal = 0;
        $itemsData = [];

        foreach ($validated['items'] as $item) {
            if ($item['type'] === 'service') {
                $service = Service::findOrFail($item['id']);
                $unitPrice = $service->price;
                $name = app()->getLocale() === 'ar' ? $service->name_ar : $service->name_en;
            } else {
                $product = Product::findOrFail($item['id']);
                $unitPrice = $product->price;
                $name = app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en;

                // Decrease stock
                if (!$product->decreaseStock($item['quantity'])) {
                    return back()->withErrors(['items' => __('admin.insufficient_stock', ['product' => $name])])->withInput();
                }
            }

            $totalPrice = $unitPrice * $item['quantity'];
            $subtotal += $totalPrice;

            $itemsData[] = [
                'item_type' => $item['type'],
                'item_id' => $item['id'],
                'item_name' => $name,
                'quantity' => $item['quantity'],
                'unit_price' => $unitPrice,
                'total_price' => $totalPrice,
            ];
        }

        // Coupon handling
        $discountAmount = $validated['discount_amount'] ?? 0;
        if (!empty($validated['coupon_code'])) {
            $coupon = Coupon::where('code', $validated['coupon_code'])
                ->where('salon_id', $salon->id)
                ->first();
            if ($coupon && $coupon->isValid()) {
                $discountAmount += $coupon->calculateDiscount($subtotal);
                $coupon->increment('used_count');
            }
        }

        $total = max(0, $subtotal - $discountAmount);
        $paidAmount = min($validated['paid_amount'], $total);
        $remaining = $total - $paidAmount;

        $status = 'unpaid';
        if ($paidAmount >= $total) $status = 'paid';
        elseif ($paidAmount > 0) $status = 'partial';

        // Create invoice
        $invoice = Invoice::create([
            'salon_id' => $salon->id,
            'client_id' => $validated['client_id'] ?? null,
            'booking_id' => $validated['booking_id'] ?? null,
            'invoice_number' => Invoice::generateNumber($salon->id),
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total' => $total,
            'payment_method' => $validated['payment_method'],
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remaining,
            'status' => $status,
            'coupon_code' => $validated['coupon_code'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Create items
        foreach ($itemsData as $itemData) {
            $invoice->items()->create($itemData);
        }

        // Add loyalty points if client exists (1 point per OMR)
        if ($invoice->client_id && $status !== 'refunded') {
            $client = Client::find($invoice->client_id);
            if ($client) {
                $client->addLoyaltyPoints((int) $paidAmount);
            }
        }

        return redirect()->route('invoice.show', [$salon, $invoice])
            ->with('success', __('admin.invoice_created'));
    }

    public function show(Salon $salon, Invoice $invoice)
    {
        $this->authorize('own', $salon);
        if ($invoice->salon_id !== $salon->id) abort(403);

        $invoice->load(['client', 'items', 'booking']);

        return view('invoices.show', compact('salon', 'invoice'));
    }

    public function addPayment(Request $request, Salon $salon, Invoice $invoice)
    {
        $this->authorize('own', $salon);
        if ($invoice->salon_id !== $salon->id) abort(403);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $invoice->remaining_amount,
        ]);

        $newPaid = $invoice->paid_amount + $validated['amount'];
        $newRemaining = $invoice->total - $newPaid;

        $invoice->update([
            'paid_amount' => $newPaid,
            'remaining_amount' => max(0, $newRemaining),
            'status' => $newRemaining <= 0 ? 'paid' : 'partial',
        ]);

        return back()->with('success', __('admin.payment_recorded'));
    }

    public function dailySales(Salon $salon)
    {
        $this->authorize('own', $salon);

        $today = today();
        $invoices = Invoice::where('salon_id', $salon->id)
            ->whereDate('created_at', $today)
            ->with(['client', 'items'])
            ->orderByDesc('created_at')
            ->get();

        $totalCash = $invoices->where('payment_method', 'cash')->sum('paid_amount');
        $totalCard = $invoices->where('payment_method', 'card')->sum('paid_amount');
        $totalWallet = $invoices->where('payment_method', 'wallet')->sum('paid_amount');
        $totalPartial = $invoices->where('payment_method', 'partial')->sum('paid_amount');
        $grandTotal = $invoices->sum('paid_amount');

        return view('invoices.daily-sales', compact(
            'salon', 'invoices', 'today',
            'totalCash', 'totalCard', 'totalWallet', 'totalPartial', 'grandTotal'
        ));
    }

    public function validateCoupon(Request $request, Salon $salon)
    {
        $coupon = Coupon::where('code', $request->code)
            ->where('salon_id', $salon->id)
            ->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json(['valid' => false, 'message' => __('admin.invalid_coupon')]);
        }

        return response()->json([
            'valid' => true,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);
    }

    public function destroy(Salon $salon, Invoice $invoice)
    {
        $this->authorize('own', $salon);
        if ($invoice->salon_id !== $salon->id) abort(403);

        // Delete invoice items first
        $invoice->items()->delete();
        $invoice->delete();

        return redirect()->route('invoice.index', $salon)
            ->with('success', __('admin.invoice_deleted'));
    }
}
