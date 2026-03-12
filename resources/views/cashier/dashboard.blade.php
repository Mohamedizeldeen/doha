@extends('admin.layout.app')

@section('page-title', __('admin.cashier_dashboard'))

@section('content')
<!-- Welcome -->
<div style="background: linear-gradient(135deg, #059669, #047857); border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem; color: #fff;">
    <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.25rem;">
        <i class="fas fa-cash-register"></i> {{ __('admin.cashier_dashboard') }}
    </h2>
    <p style="font-size: 0.85rem; opacity: 0.8;">{{ now()->format('l, d M Y') }}</p>
</div>

<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: linear-gradient(135deg, #fdf2f8, #fce7f3); border-radius: 1rem; padding: 1.25rem; border: 1px solid #fbcfe8;">
        <div style="font-size: 0.7rem; color: #9d174d; font-weight: 600;">{{ __('admin.today_revenue') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary); margin-top: 0.25rem;">{{ number_format($todayRevenue, 2) }}</div>
        <div style="font-size: 0.65rem; color: #be185d;">{{ $salon->currency ?? 'OMR' }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 1rem; padding: 1.25rem; border: 1px solid #bfdbfe;">
        <div style="font-size: 0.7rem; color: #1e40af; font-weight: 600;">{{ __('admin.today_invoices') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #2563eb; margin-top: 0.25rem;">{{ $todayInvoices }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 1rem; padding: 1.25rem; border: 1px solid #bbf7d0;">
        <div style="font-size: 0.7rem; color: #166534; font-weight: 600;">{{ __('admin.cash_total') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #059669; margin-top: 0.25rem;">{{ number_format($todayCash, 2) }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #fefce8, #fef3c7); border-radius: 1rem; padding: 1.25rem; border: 1px solid #fde68a;">
        <div style="font-size: 0.7rem; color: #92400e; font-weight: 600;">{{ __('admin.card_total') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #d97706; margin-top: 0.25rem;">{{ number_format($todayCard, 2) }}</div>
    </div>
</div>

<!-- Quick Action -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('invoice.create', $salon) }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border-radius: 0.75rem; text-decoration: none; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-plus-circle"></i> {{ __('admin.new_invoice') }}
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- Pending Bookings (need invoicing) -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden;">
        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: 0.95rem; font-weight: 700; color: #1f2937;">
                <i class="fas fa-clock" style="color: #d97706;"></i> {{ __('admin.pending_invoicing') }}
            </h3>
        </div>
        @forelse($pendingBookings as $booking)
        <div style="padding: 0.75rem 1.25rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 0.8rem; font-weight: 600; color: #1f2937;">
                    {{ $booking->client ? (app()->getLocale() === 'ar' ? $booking->client->name_ar : $booking->client->name_en) : '-' }}
                </div>
                <div style="font-size: 0.7rem; color: #6b7280;">
                    {{ $booking->service ? (app()->getLocale() === 'ar' ? $booking->service->name_ar : $booking->service->name_en) : '' }}
                    · {{ number_format($booking->service->price ?? 0, 2) }} {{ $salon->currency ?? 'OMR' }}
                </div>
            </div>
            <a href="{{ route('invoice.create', [$salon, 'booking_id' => $booking->id]) }}" style="padding: 0.3rem 0.6rem; background: var(--primary); color: #fff; border-radius: 0.375rem; text-decoration: none; font-size: 0.7rem; font-weight: 600;">
                <i class="fas fa-file-invoice"></i> {{ __('admin.invoice') }}
            </a>
        </div>
        @empty
        <div style="padding: 2rem; text-align: center; color: #9ca3af; font-size: 0.8rem;">
            {{ __('admin.no_pending_invoicing') }}
        </div>
        @endforelse
    </div>

    <!-- Recent Invoices -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden;">
        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 0.95rem; font-weight: 700; color: #1f2937;">
                <i class="fas fa-receipt" style="color: var(--primary);"></i> {{ __('admin.recent_invoices') }}
            </h3>
            <a href="{{ route('invoice.index', $salon) }}" style="font-size: 0.75rem; color: var(--primary); text-decoration: none;">{{ __('admin.view_all') }} →</a>
        </div>
        @forelse($recentInvoices as $invoice)
        <div style="padding: 0.75rem 1.25rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 0.75rem; font-weight: 600; color: var(--primary);">{{ $invoice->invoice_number }}</div>
                <div style="font-size: 0.7rem; color: #6b7280;">
                    {{ $invoice->client ? (app()->getLocale() === 'ar' ? $invoice->client->name_ar : $invoice->client->name_en) : __('admin.walk_in_client') }}
                </div>
            </div>
            <div style="text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                <div style="font-size: 0.85rem; font-weight: 700; color: #1f2937;">{{ number_format($invoice->total, 2) }}</div>
                @php
                    $sc = ['paid' => '#059669', 'partial' => '#d97706', 'unpaid' => '#ef4444', 'refunded' => '#6b7280'];
                    $sb = ['paid' => '#dcfce7', 'partial' => '#fef3c7', 'unpaid' => '#fee2e2', 'refunded' => '#f3f4f6'];
                @endphp
                <span style="font-size: 0.6rem; padding: 0.1rem 0.35rem; border-radius: 9999px; background: {{ $sb[$invoice->status] ?? '#f3f4f6' }}; color: {{ $sc[$invoice->status] ?? '#6b7280' }};">
                    {{ __('admin.inv_' . $invoice->status) }}
                </span>
            </div>
        </div>
        @empty
        <div style="padding: 2rem; text-align: center; color: #9ca3af; font-size: 0.8rem;">
            {{ __('admin.no_invoices_today') }}
        </div>
        @endforelse
    </div>
</div>

@endsection
