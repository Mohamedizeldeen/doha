@extends('admin.layout.app')

@section('page-title', __('admin.daily_sales'))

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.daily_sales') }} - {{ $today->format('d/m/Y') }}</h2>
</div>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: #fff; border-radius: 0.75rem; padding: 1rem; border: 1px solid #e5e7eb; text-align: center;">
        <div style="font-size: 0.7rem; color: #6b7280;"><i class="fas fa-money-bill-wave" style="color: #059669;"></i> {{ __('admin.pay_cash') }}</div>
        <div style="font-size: 1.25rem; font-weight: 800; color: #059669;">{{ number_format($totalCash, 2) }}</div>
    </div>
    <div style="background: #fff; border-radius: 0.75rem; padding: 1rem; border: 1px solid #e5e7eb; text-align: center;">
        <div style="font-size: 0.7rem; color: #6b7280;"><i class="fas fa-credit-card" style="color: #2563eb;"></i> {{ __('admin.pay_card') }}</div>
        <div style="font-size: 1.25rem; font-weight: 800; color: #2563eb;">{{ number_format($totalCard, 2) }}</div>
    </div>
    <div style="background: #fff; border-radius: 0.75rem; padding: 1rem; border: 1px solid #e5e7eb; text-align: center;">
        <div style="font-size: 0.7rem; color: #6b7280;"><i class="fas fa-wallet" style="color: #7c3aed;"></i> {{ __('admin.pay_wallet') }}</div>
        <div style="font-size: 1.25rem; font-weight: 800; color: #7c3aed;">{{ number_format($totalWallet, 2) }}</div>
    </div>
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 0.75rem; padding: 1rem; text-align: center;">
        <div style="font-size: 0.7rem; color: rgba(255,255,255,0.8);">{{ __('admin.grand_total') }}</div>
        <div style="font-size: 1.25rem; font-weight: 800; color: #fff;">{{ number_format($grandTotal, 2) }} {{ $salon->currency ?? 'OMR' }}</div>
    </div>
</div>

<!-- Invoices List -->
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">#</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.time') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.client') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.items') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.total') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.payment_method') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
            <tr style="border-bottom: 1px solid #f3f4f6;" onclick="window.location='{{ route('invoice.show', [$salon, $invoice]) }}'" style="cursor: pointer;">
                <td style="padding: 0.75rem; font-size: 0.75rem; color: var(--primary); font-weight: 600;">{{ $invoice->invoice_number }}</td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #374151;">{{ $invoice->created_at->format('H:i') }}</td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #374151;">
                    {{ $invoice->client ? (app()->getLocale() === 'ar' ? $invoice->client->name_ar : $invoice->client->name_en) : __('admin.walk_in_client') }}
                </td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #374151;">{{ $invoice->items->count() }}</td>
                <td style="padding: 0.75rem; font-size: 0.85rem; font-weight: 700; color: #1f2937;">{{ number_format($invoice->paid_amount, 2) }}</td>
                <td style="padding: 0.75rem;">
                    <span style="font-size: 0.7rem; padding: 0.15rem 0.4rem; border-radius: 9999px; background: #f3f4f6;">
                        {{ __('admin.pay_' . $invoice->payment_method) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 3rem; text-align: center; color: #9ca3af; font-size: 0.85rem;">
                    {{ __('admin.no_sales_today') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 1rem;">
    <a href="{{ route('invoice.index', $salon) }}" style="padding: 0.5rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; text-decoration: none; font-size: 0.8rem; color: #6b7280;">
        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
    </a>
</div>
@endsection
