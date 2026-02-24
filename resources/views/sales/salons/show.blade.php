@extends('sales.layout.app')

@section('page-title', app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar))

@section('content')
<style>
    .detail-card { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 1.25rem; }
    .detail-header { display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap; }
    .detail-logo { width: 72px; height: 72px; border-radius: 1rem; object-fit: cover; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #94a3b8; flex-shrink: 0; }
    .detail-title { font-size: 1.3rem; font-weight: 800; color: #1a1a2e; }
    .detail-subtitle { font-size: 0.85rem; color: #64748b; margin-top: 0.2rem; }
    .stat-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; }
    .mini-stat { text-align: center; padding: 1rem; background: #f8fafc; border-radius: 0.75rem; }
    .mini-stat-value { font-size: 1.4rem; font-weight: 800; color: #1a1a2e; }
    .mini-stat-label { font-size: 0.75rem; color: #94a3b8; margin-top: 0.2rem; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .info-item label { font-size: 0.75rem; font-weight: 600; color: #94a3b8; display: block; margin-bottom: 0.2rem; }
    .info-item span { font-size: 0.9rem; color: #1a1a2e; font-weight: 600; }
    .badge { padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-expired { background: #fee2e2; color: #991b1b; }
    .badge-trial { background: #fef3c7; color: #92400e; }
    .badge-monthly { background: #dcfce7; color: #166534; }
    .badge-yearly { background: #dbeafe; color: #1e40af; }
    .table-wrapper { overflow-x: auto; border-radius: 0.75rem; border: 1px solid #f1f5f9; }
    .data-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }
    .data-table th { background: #f8fafc; padding: 0.75rem 1rem; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-weight: 600; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .data-table td { padding: 0.75rem 1rem; border-top: 1px solid #f1f5f9; color: #334155; }
    .data-table tr:hover td { background: #fafbfc; }
    .section-title { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
    .section-title i { color: #dd208e; }
    .summary-card { background: linear-gradient(135deg, #fdf2f8, #fff); border: 1px solid rgba(221,32,142,0.1); border-radius: 0.75rem; padding: 1rem 1.25rem; text-align: center; }
    .summary-card .value { font-size: 1.3rem; font-weight: 800; color: #dd208e; }
    .summary-card .label { font-size: 0.75rem; color: #64748b; margin-top: 0.15rem; }
    @media (max-width: 768px) { .info-grid { grid-template-columns: 1fr; } .stat-row { grid-template-columns: repeat(2, 1fr); } }
</style>

<div style="margin-bottom: 1rem;">
    <a href="{{ route('sales.salons.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        {{ __('admin.back') }}
    </a>
</div>

{{-- Header --}}
<div class="detail-card">
    <div class="detail-header">
        @if($salon->logo)
            <img src="{{ asset('storage/' . $salon->logo) }}" alt="" class="detail-logo" style="display: block;">
        @else
            <div class="detail-logo"><i class="fas fa-store"></i></div>
        @endif
        <div style="flex: 1;">
            <div class="detail-title">{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}</div>
            <div class="detail-subtitle">
                @if($salon->subscription_type === 'trial')
                    <span class="badge badge-trial">{{ __('admin.trial') }}</span>
                @elseif($salon->isSubscriptionActive())
                    <span class="badge badge-active">{{ __('admin.active') }}</span>
                @else
                    <span class="badge badge-expired">{{ __('admin.expired') }}</span>
                @endif
                &middot; {{ ucfirst($salon->subscription_type ?? 'trial') }}
                &middot; {{ __('admin.days_remaining') }}: {{ $salon->daysRemaining() }}
            </div>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="stat-row" style="margin-bottom: 1.25rem;">
    <div class="mini-stat">
        <div class="mini-stat-value">{{ $total_bookings }}</div>
        <div class="mini-stat-label">{{ __('admin.bookings') }}</div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-value">{{ $completed_bookings }}</div>
        <div class="mini-stat-label">{{ __('admin.completed') }}</div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-value">{{ $salon->services->count() }}</div>
        <div class="mini-stat-label">{{ __('admin.services') }}</div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-value">{{ $salon->staff->count() }}</div>
        <div class="mini-stat-label">{{ __('admin.staff') }}</div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-value" style="color: #dd208e;">{{ number_format($totalPaid, 2) }} <span style="font-size: 0.7rem;">{{ __('admin.omr') }}</span></div>
        <div class="mini-stat-label">{{ __('admin.total_paid') }}</div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-value" style="color: #16a34a;">{{ number_format($totalCommission, 2) }} <span style="font-size: 0.7rem;">{{ __('admin.omr') }}</span></div>
        <div class="mini-stat-label">{{ __('admin.my_commission') }}</div>
    </div>
</div>

{{-- Salon Info --}}
<div class="detail-card">
    <div class="section-title"><i class="fas fa-info-circle"></i> {{ __('admin.salon_info') }}</div>
    <div class="info-grid">
        <div class="info-item">
            <label>{{ __('admin.name_ar') }}</label>
            <span>{{ $salon->name_ar }}</span>
        </div>
        <div class="info-item">
            <label>{{ __('admin.name_en') }}</label>
            <span>{{ $salon->name_en ?? '—' }}</span>
        </div>
        <div class="info-item">
            <label>{{ __('admin.phone') }}</label>
            <span dir="ltr">{{ $salon->phone ?? '—' }}</span>
        </div>
        <div class="info-item">
            <label>{{ __('admin.address') }}</label>
            <span>{{ app()->getLocale() === 'ar' ? ($salon->address_ar ?? $salon->address ?? '—') : ($salon->address ?? '—') }}</span>
        </div>
        <div class="info-item">
            <label>{{ __('admin.subscription_start') }}</label>
            <span>{{ $salon->subscription_start_date ? \Carbon\Carbon::parse($salon->subscription_start_date)->format('Y-m-d') : '—' }}</span>
        </div>
        <div class="info-item">
            <label>{{ __('admin.subscription_end') }}</label>
            <span>{{ $salon->subscription_end_date ? \Carbon\Carbon::parse($salon->subscription_end_date)->format('Y-m-d') : '—' }}</span>
        </div>
        <div class="info-item">
            <label>{{ __('admin.owner') }}</label>
            <span>{{ $salon->user->name ?? '—' }}</span>
        </div>
        <div class="info-item">
            <label>{{ __('admin.email') }}</label>
            <span dir="ltr">{{ $salon->user->email ?? '—' }}</span>
        </div>
    </div>
</div>

{{-- Payment History --}}
<div class="detail-card">
    <div class="section-title"><i class="fas fa-receipt"></i> {{ __('admin.payment_history') }}</div>

    {{-- Payment Summary --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.25rem;">
        <div class="summary-card">
            <div class="value">{{ $payments->count() }}</div>
            <div class="label">{{ __('admin.total_payments_count') }}</div>
        </div>
        <div class="summary-card">
            <div class="value">{{ number_format($totalPaid, 2) }} {{ __('admin.omr') }}</div>
            <div class="label">{{ __('admin.total_paid') }}</div>
        </div>
        <div class="summary-card">
            <div class="value" style="color: #16a34a;">{{ number_format($totalCommission, 2) }} {{ __('admin.omr') }}</div>
            <div class="label">{{ __('admin.my_commission') }}</div>
        </div>
    </div>

    @if($payments->count())
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.subscription_type') }}</th>
                    <th>{{ __('admin.amount') }}</th>
                    <th>{{ __('admin.my_commission') }}</th>
                    <th>{{ __('admin.period') }}</th>
                    <th>{{ __('admin.date') }}</th>
                    <th>{{ __('admin.notes') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($payment->subscription_type === 'monthly')
                            <span class="badge badge-monthly">{{ __('admin.monthly') }}</span>
                        @else
                            <span class="badge badge-yearly">{{ __('admin.yearly') }}</span>
                        @endif
                    </td>
                    <td style="font-weight: 600;">{{ number_format($payment->amount, 2) }} {{ __('admin.omr') }}</td>
                    <td style="color: #16a34a; font-weight: 600;">{{ number_format($payment->commission_amount, 2) }} {{ __('admin.omr') }}</td>
                    <td style="font-size: 0.8rem;" dir="ltr">{{ $payment->period_start?->format('Y-m-d') }} → {{ $payment->period_end?->format('Y-m-d') }}</td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td style="font-size: 0.8rem; color: #64748b;">{{ $payment->notes ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p style="text-align: center; color: #94a3b8; padding: 2rem;">{{ __('admin.no_payments_yet') }}</p>
    @endif
</div>

{{-- Recent Bookings --}}
<div class="detail-card">
    <div class="section-title"><i class="fas fa-calendar-check"></i> {{ __('admin.recent_bookings') }}</div>
    @php $recentBookings = $salon->bookings()->with('client', 'service')->latest()->take(10)->get(); @endphp
    @if($recentBookings->count())
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('admin.client') }}</th>
                    <th>{{ __('admin.service') }}</th>
                    <th>{{ __('admin.date') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.price') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $booking)
                <tr>
                    <td>{{ $booking->client->name ?? '—' }}</td>
                    <td>{{ app()->getLocale() === 'ar' ? ($booking->service->name_ar ?? '') : ($booking->service->name_en ?? $booking->service->name_ar ?? '') }}</td>
                    <td dir="ltr">{{ $booking->date ?? '—' }}</td>
                    <td>
                        @php
                            $statusColors = ['completed' => '#16a34a', 'confirmed' => '#2563eb', 'pending' => '#eab308', 'cancelled' => '#ef4444'];
                            $color = $statusColors[$booking->status] ?? '#94a3b8';
                        @endphp
                        <span style="color: {{ $color }}; font-weight: 600;">{{ __('admin.' . ($booking->status ?? 'pending')) }}</span>
                    </td>
                    <td>{{ number_format($booking->total_price ?? 0, 2) }} {{ __('admin.omr') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p style="text-align: center; color: #94a3b8; padding: 2rem;">{{ __('admin.no_bookings_yet') }}</p>
    @endif
</div>
@endsection
