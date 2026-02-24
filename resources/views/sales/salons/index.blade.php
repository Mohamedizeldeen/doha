@extends('sales.layout.app')

@section('page-title', __('admin.my_salons'))

@section('content')
<style>
    .salon-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.25rem; }
    .salon-card { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; transition: all 0.3s; }
    .salon-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .salon-card-header { padding: 1.25rem; display: flex; align-items: center; gap: 1rem; }
    .salon-logo { width: 56px; height: 56px; border-radius: 0.75rem; object-fit: cover; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #94a3b8; flex-shrink: 0; }
    .salon-name { font-size: 1rem; font-weight: 700; color: #1a1a2e; }
    .salon-subtitle { font-size: 0.8rem; color: #64748b; margin-top: 0.15rem; }
    .salon-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; border-top: 1px solid #f1f5f9; }
    .salon-stat { text-align: center; padding: 0.85rem 0.5rem; border-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 1px solid #f1f5f9; }
    .salon-stat:last-child { border: none; }
    .salon-stat-value { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; }
    .salon-stat-label { font-size: 0.7rem; color: #94a3b8; margin-top: 0.15rem; }
    .badge { padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-expired { background: #fee2e2; color: #991b1b; }
</style>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <p style="font-size: 0.85rem; color: #64748b;">{{ __('admin.total') }}: {{ $salons->total() }} {{ __('admin.salons') }}</p>
    </div>
    <a href="{{ route('sales.salons.create') }}" style="background: linear-gradient(135deg, #dd208e, #b01670); color: #fff; padding: 0.6rem 1.25rem; border-radius: 0.625rem; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-plus"></i> {{ __('admin.create_salon') }}
    </a>
</div>

<div class="salon-grid">
    @forelse($salons as $salon)
    <div class="salon-card">
        <div class="salon-card-header">
            @if($salon->logo)
                <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ $salon->name_en }}" class="salon-logo" style="display: block;">
            @else
                <div class="salon-logo"><i class="fas fa-store"></i></div>
            @endif
            <div style="flex: 1; min-width: 0;">
                <div class="salon-name">{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}</div>
                <div class="salon-subtitle">
                    @if($salon->isSubscriptionActive())
                        <span class="badge badge-active">{{ __('admin.active') }}</span>
                    @else
                        <span class="badge badge-expired">{{ __('admin.expired') }}</span>
                    @endif
                    &middot; {{ ucfirst($salon->subscription_type ?? 'trial') }}
                </div>
            </div>
            <a href="{{ route('sales.salons.show', $salon) }}" style="color: #dd208e; font-size: 1.1rem;">
                <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i>
            </a>
        </div>
        <div class="salon-stats">
            <div class="salon-stat">
                <div class="salon-stat-value">{{ $salon->bookings_count }}</div>
                <div class="salon-stat-label">{{ __('admin.bookings') }}</div>
            </div>
            <div class="salon-stat">
                <div class="salon-stat-value">{{ number_format($salon->total_paid ?? 0, 1) }}</div>
                <div class="salon-stat-label">{{ __('admin.total_paid') }}</div>
            </div>
            <div class="salon-stat">
                <div class="salon-stat-value" style="color: #16a34a;">{{ number_format($salon->salon_commission ?? 0, 1) }}</div>
                <div class="salon-stat-label">{{ __('admin.my_commission') }}</div>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #94a3b8;">
        <i class="fas fa-store-slash" style="font-size: 2.5rem; margin-bottom: 1rem; display: block;"></i>
        <p>{{ __('admin.no_salons_yet') }}</p>
    </div>
    @endforelse
</div>

@if($salons->hasPages())
<div style="margin-top: 1.5rem; display: flex; justify-content: center;">
    {{ $salons->links() }}
</div>
@endif
@endsection
