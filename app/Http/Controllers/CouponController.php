<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index(Salon $salon)
    {
        $this->authorize('own', $salon);

        $coupons = Coupon::where('salon_id', $salon->id)
            ->orderByDesc('created_at')
            ->get();

        return view('coupons.index', compact('salon', 'coupons'));
    }

    public function create(Salon $salon)
    {
        $this->authorize('own', $salon);
        return view('coupons.create', compact('salon'));
    }

    public function store(Request $request, Salon $salon)
    {
        $this->authorize('own', $salon);

        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
        ]);

        Coupon::create([
            'salon_id' => $salon->id,
            'code' => $validated['code'] ?? strtoupper(Str::random(8)),
            'type' => $validated['type'],
            'value' => $validated['value'],
            'min_order_amount' => $validated['min_order_amount'] ?? 0,
            'max_uses' => $validated['max_uses'] ?? null,
            'valid_from' => $validated['valid_from'] ?? null,
            'valid_until' => $validated['valid_until'] ?? null,
        ]);

        return redirect()->route('coupon.index', $salon)
            ->with('success', __('admin.coupon_created'));
    }

    public function destroy(Salon $salon, Coupon $coupon)
    {
        $this->authorize('own', $salon);
        if ($coupon->salon_id !== $salon->id) abort(403);

        $coupon->delete();

        return redirect()->route('coupon.index', $salon)
            ->with('success', __('admin.coupon_deleted'));
    }
}
