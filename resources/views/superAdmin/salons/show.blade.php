@extends('superAdmin.layout.app')

@section('page-title', app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar))

@section('content')

<div class="mb-6">
    <a href="{{ route('superAdmin.salons.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">← {{ __('admin.back_to_salons') }}</a>
</div>

<!-- Salon Header -->
<div class="bg-white rounded-lg shadow-md p-8 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}</h1>
            <p class="text-gray-600 mt-2">{{ $salon->address_ar }}</p>
        </div>
        <div class="text-right">
            @if($salon->logo)
                <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}" class="w-24 h-24 rounded-lg object-cover">
            @endif
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">{{ __('admin.phone') }}</p>
            <p class="text-lg font-semibold text-gray-900 ltr">{{ $salon->phone }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">{{ __('admin.email') }}</p>
            <p class="text-lg font-semibold text-gray-900 ltr">{{ $salon->email }}</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">{{ __('admin.owner') }}</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->user->name }}</p>
        </div>
        <div class="bg-orange-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">{{ __('admin.currency') }}</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->currency }}</p>
        </div>
        <div class="bg-orange-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">{{ __('admin.subscription_type') }}</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->subscription_type }}</p>
        </div>
          <div class="bg-orange-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">{{ __('admin.subscription_date') }}</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->subscription_start_date ? $salon->subscription_start_date->format('d/m/Y') : __('admin.not_specified') }}</p>
        </div>  
        <div class="bg-red-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">{{ __('admin.subscription_end_date_label') }}</p>
            <p class="text-lg font-semibold text-gray-900">{{ $salon->subscription_end_date ? $salon->subscription_end_date->format('d/m/Y') : __('admin.not_specified') }}</p>
        </div>  
        @if($salon->salesUser)
        <div class="bg-pink-50 p-4 rounded-lg">
            <p class="text-gray-600 text-sm">{{ __('admin.sales_person') }}</p>
            <p class="text-lg font-semibold" style="color: #dd208e;">{{ $salon->salesUser->name }}</p>
        </div>
        @endif

        <div class="p-4 rounded-lg {{ $salon->user && $salon->user->is_active ? 'bg-green-50' : 'bg-red-50' }}">
            <p class="text-gray-600 text-sm">{{ __('admin.account_status') }}</p>
            <div class="flex items-center justify-between mt-1">
                @if($salon->user && $salon->user->is_active)
                    <p class="text-lg font-semibold text-green-700"><i class="fas fa-check-circle"></i> {{ __('admin.active') }}</p>
                @else
                    <p class="text-lg font-semibold text-red-700"><i class="fas fa-ban"></i> {{ __('admin.blocked') }}</p>
                @endif
                <form action="{{ route('superAdmin.salons.toggleStatus', $salon->id) }}" method="POST">
                    @csrf
                    @if($salon->user && $salon->user->is_active)
                        <button type="submit" onclick="return confirm('{{ __('admin.confirm_block_salon') }}')"
                            class="px-3 py-1.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-ban"></i> {{ __('admin.block') }}
                        </button>
                    @else
                        <button type="submit"
                            class="px-3 py-1.5 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-check-circle"></i> {{ __('admin.unblock') }}
                        </button>
                    @endif
                </form>
            </div>
        </div>
        
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <p class="text-gray-600 text-sm font-medium">{{ __('admin.services') }}</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $salon->services->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <p class="text-gray-600 text-sm font-medium">{{ __('admin.staff') }}</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $salon->staff->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
        <p class="text-gray-600 text-sm font-medium">{{ __('admin.products') }}</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $salon->products->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
        <p class="text-gray-600 text-sm font-medium">{{ __('admin.bookings') }}</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $total_bookings }}</p>
    </div>
</div>

<!-- Booking Status -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg shadow-md p-6 border-l-4 border-green-600">
        <p class="text-gray-600 text-sm font-medium">{{ __('admin.completed_bookings') }}</p>
        <p class="text-2xl font-bold text-green-700 mt-2">{{ $completed_bookings }}</p>
        <p class="text-sm text-gray-600 mt-2">{{ __('admin.revenue') }}: {{ number_format($revenue, 2) }}</p>
    </div>
    
    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-lg shadow-md p-6 border-l-4 border-yellow-600">
        <p class="text-gray-600 text-sm font-medium">{{ __('admin.pending_bookings') }}</p>
        <p class="text-2xl font-bold text-yellow-700 mt-2">{{ $total_bookings - $completed_bookings }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-600">
        <p class="text-gray-600 text-sm font-medium">{{ __('admin.clients') }}</p>
        <p class="text-2xl font-bold text-indigo-700 mt-2">{{ $salon->clients->count() }}</p>
    </div>
</div>

<!-- Services Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('admin.services') }} ({{ $salon->services->count() }})</h2>
    @if($salon->services->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($salon->services as $service)
                <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                    <p class="font-semibold text-gray-900">{{ app()->getLocale() === 'ar' ? $service->name_ar : ($service->name_en ?? $service->name_ar) }}</p>
                    <p class="text-sm text-gray-600">{{ app()->getLocale() === 'ar' ? $service->description_ar : ($service->description_en ?? $service->description_ar) }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm text-gray-700">{{ __('admin.duration') }}: {{ $service->duration }} {{ __('admin.minutes') }}</span>
                        <span class="font-bold text-blue-600">{{ $service->price }} {{ $salon->currency }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">{{ __('admin.no_services') }}</p>
    @endif
</div>

<!-- Products Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('admin.products') }} ({{ $salon->products->count() }})</h2>
    @if($salon->products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($salon->products as $product)
                <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                    <p class="font-semibold text-gray-900">{{ app()->getLocale() === 'ar' ? $product->name_ar : ($product->name_en ?? $product->name_ar) }}</p>
                    <p class="text-sm text-gray-600">{{ app()->getLocale() === 'ar' ? $product->description_ar : ($product->description_en ?? $product->description_ar) }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm text-gray-700">{{ __('admin.stock') }}: {{ $product->stock_quantity }}</span>
                        <span class="font-bold text-green-600">{{ $product->price }} {{ $salon->currency }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">{{ __('admin.no_products') }}</p>
    @endif
</div>

<!-- Payment History -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-900">
            <i class="fas fa-receipt" style="color: #dd208e;"></i> {{ __('admin.payment_history') }}
        </h2>
        <button onclick="document.getElementById('salonPaymentModal').classList.add('active')"
            class="px-4 py-2 text-white text-sm font-semibold rounded-lg transition"
            style="background: linear-gradient(135deg, #dd208e, #9333ea);">
            <i class="fas fa-plus-circle"></i> {{ __('admin.record_payment') }}
        </button>
    </div>

    {{-- Summary row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="p-4 rounded-lg" style="background: linear-gradient(135deg, #dd208e10, #9333ea10); border: 1px solid #dd208e30;">
            <p class="text-gray-600 text-sm">{{ __('admin.total_paid') }}</p>
            <p class="text-2xl font-bold" style="color: #dd208e;">{{ number_format($totalPaid, 1) }} <span class="text-sm font-normal">{{ __('admin.omr') }}</span></p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <p class="text-gray-600 text-sm">{{ __('admin.total_commissions') }}</p>
            <p class="text-2xl font-bold text-green-700">{{ number_format($totalCommission, 1) }} <span class="text-sm font-normal">{{ __('admin.omr') }}</span></p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <p class="text-gray-600 text-sm">{{ __('admin.total_payments_count') }}</p>
            <p class="text-2xl font-bold text-blue-700">{{ $salon->payments->where('status', 'paid')->count() }}</p>
        </div>
    </div>

    @if($salon->payments->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">#</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.subscription_type') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.amount') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.commission') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.sales_person') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.period') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.date') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.notes') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salon->payments as $index => $payment)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $payment->subscription_type === 'yearly' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ __('admin.' . $payment->subscription_type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-bold text-green-700">{{ number_format($payment->amount, 1) }} {{ __('admin.omr') }}</td>
                            <td class="px-4 py-3">
                                @if($payment->commission_amount > 0)
                                    <span class="font-semibold" style="color: #ea580c;">{{ number_format($payment->commission_amount, 1) }} {{ __('admin.omr') }}</span>
                                    <span class="text-xs text-gray-400">({{ $payment->commission_rate }}%)</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $payment->salesUser->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-xs" dir="ltr">
                                {{ $payment->period_start->format('d/m/Y') }} → {{ $payment->period_end->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3" dir="ltr">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $payment->status === 'paid' ? 'bg-green-100 text-green-700' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ __('admin.payment_' . $payment->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500">{{ $payment->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8">
            <i class="fas fa-receipt text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">{{ __('admin.no_payments_yet') }}</p>
        </div>
    @endif
</div>

{{-- Record Payment Modal --}}
<style>
    .salon-payment-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .salon-payment-overlay.active { display: flex; }
</style>
<div class="salon-payment-overlay" id="salonPaymentModal">
    <div style="background: #fff; border-radius: 1.25rem; padding: 2rem; width: 90%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #1a1a2e; margin: 0;">
                <i class="fas fa-receipt" style="color: #dd208e; margin-inline-end: 0.5rem;"></i>{{ __('admin.record_payment') }}
            </h3>
            <button onclick="document.getElementById('salonPaymentModal').classList.remove('active')" style="background: none; border: none; font-size: 1.2rem; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>
        <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 1rem;">
            {{ __('admin.salon') }}: <strong style="color: #1a1a2e;">{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}</strong>
        </div>
        <form action="{{ route('superAdmin.salons.recordPayment', $salon->id) }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">{{ __('admin.subscription_type') }}</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem; border: 2px solid #dd208e; border-radius: 0.75rem; cursor: pointer;" id="sMonthly">
                        <input type="radio" name="subscription_type" value="monthly" checked onchange="document.getElementById('sMonthly').style.borderColor='#dd208e'; document.getElementById('sYearly').style.borderColor='#e2e8f0';" style="accent-color: #dd208e;">
                        <div>
                            <div style="font-weight: 700; font-size: 0.85rem; color: #1a1a2e;">{{ __('admin.monthly') }}</div>
                            <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600;">15 {{ __('admin.omr') }}</div>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; cursor: pointer;" id="sYearly">
                        <input type="radio" name="subscription_type" value="yearly" onchange="document.getElementById('sYearly').style.borderColor='#dd208e'; document.getElementById('sMonthly').style.borderColor='#e2e8f0';" style="accent-color: #dd208e;">
                        <div>
                            <div style="font-weight: 700; font-size: 0.85rem; color: #1a1a2e;">{{ __('admin.yearly') }}</div>
                            <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600;">120 {{ __('admin.omr') }}</div>
                        </div>
                    </label>
                </div>
            </div>
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">{{ __('admin.notes') }}</label>
                <textarea name="notes" rows="2" style="width: 100%; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.5rem 0.75rem; font-size: 0.8rem; resize: none; font-family: inherit;" placeholder="{{ __('admin.payment_notes_placeholder') }}"></textarea>
            </div>
            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #dd208e, #9333ea); color: #fff; border: none; padding: 0.75rem; border-radius: 0.75rem; font-size: 0.9rem; font-weight: 700; cursor: pointer;">
                <i class="fas fa-check-circle"></i> {{ __('admin.confirm_payment') }}
            </button>
        </form>
    </div>
</div>
<script>
    document.getElementById('salonPaymentModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
</script>

<!-- Recent Bookings -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('admin.recent_bookings') }}</h2>
    @if($salon->bookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.client') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.service') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.appointment') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('admin.price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salon->bookings->sortByDesc('appointment_datetime')->take(5) as $booking)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $booking->client->name ?? __('admin.not_specified') }}</td>
                            <td class="px-4 py-3">{{ $booking->service->name_ar ?? __('admin.not_specified') }}</td>
                            <td class="px-4 py-3">{{ $booking->appointment_datetime->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($booking->status === 'completed') bg-green-100 text-green-700
                                    @elseif($booking->status === 'scheduled') bg-blue-100 text-blue-700
                                    @else bg-red-100 text-red-700 @endif">
                                    @switch($booking->status)
                                        @case('completed') {{ __('admin.completed_f') }} @break
                                        @case('scheduled') {{ __('admin.scheduled_f') }} @break
                                        @default {{ __('admin.cancelled_f') }} @endswitch
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold">{{ number_format($booking->price ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">{{ __('admin.no_bookings') }}</p>
    @endif
</div>

@endsection
