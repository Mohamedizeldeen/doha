@extends('admin.layout.app')

@section('page-title', __('admin.invoice_details'))

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Invoice Header -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.5rem; margin-bottom: 1rem;">
        <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--primary); margin-bottom: 0.25rem;">{{ $invoice->invoice_number }}</h2>
                <div style="font-size: 0.8rem; color: #6b7280;">{{ $invoice->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div>
                @php
                    $statusStyles = [
                        'paid' => 'background: #dcfce7; color: #166534;',
                        'partial' => 'background: #fef3c7; color: #92400e;',
                        'unpaid' => 'background: #fee2e2; color: #991b1b;',
                        'refunded' => 'background: #f3f4f6; color: #6b7280;',
                    ];
                @endphp
                <span style="padding: 0.4rem 1rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; {{ $statusStyles[$invoice->status] ?? '' }}">
                    {{ __('admin.inv_' . $invoice->status) }}
                </span>
            </div>
        </div>

        @if($invoice->client)
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f3f4f6;">
            <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">{{ __('admin.client') }}</div>
            <div style="font-size: 0.9rem; font-weight: 600; color: #1f2937;">
                {{ app()->getLocale() === 'ar' ? $invoice->client->name_ar : $invoice->client->name_en }}
            </div>
            <div style="font-size: 0.8rem; color: #6b7280;">{{ $invoice->client->phone }}</div>
        </div>
        @endif
    </div>

    <!-- Items -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; margin-bottom: 1rem;">
        <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">{{ __('admin.invoice_items') }}</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 0.5rem; font-size: 0.7rem; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.item') }}</th>
                    <th style="padding: 0.5rem; font-size: 0.7rem; color: #6b7280; text-align: center;">{{ __('admin.quantity') }}</th>
                    <th style="padding: 0.5rem; font-size: 0.7rem; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">{{ __('admin.price') }}</th>
                    <th style="padding: 0.5rem; font-size: 0.7rem; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">{{ __('admin.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.75rem 0.5rem;">
                        <span style="font-size: 0.6rem; padding: 0.1rem 0.35rem; background: {{ $item->item_type === 'service' ? '#fdf2f8' : '#f0f9ff' }}; color: {{ $item->item_type === 'service' ? 'var(--primary)' : '#2563eb' }}; border-radius: 0.25rem;">
                            {{ __('admin.' . $item->item_type) }}
                        </span>
                        <span style="font-size: 0.85rem; font-weight: 600; margin-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 0.5rem;">{{ $item->item_name }}</span>
                    </td>
                    <td style="padding: 0.75rem 0.5rem; text-align: center; font-size: 0.85rem;">{{ $item->quantity }}</td>
                    <td style="padding: 0.75rem 0.5rem; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}; font-size: 0.85rem;">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="padding: 0.75rem 0.5rem; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}; font-size: 0.85rem; font-weight: 700;">{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; margin-bottom: 1rem;">
        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; color: #6b7280;">
            <span>{{ __('admin.subtotal') }}</span>
            <span>{{ number_format($invoice->subtotal, 2) }}</span>
        </div>
        @if($invoice->discount_amount > 0)
        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; color: #dc2626;">
            <span>{{ __('admin.discount') }} {{ $invoice->coupon_code ? "({$invoice->coupon_code})" : '' }}</span>
            <span>-{{ number_format($invoice->discount_amount, 2) }}</span>
        </div>
        @endif
        <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; font-size: 1.1rem; font-weight: 800; border-top: 2px solid #e5e7eb; margin-top: 0.5rem;">
            <span>{{ __('admin.total') }}</span>
            <span style="color: var(--primary);">{{ number_format($invoice->total, 2) }} {{ $salon->currency ?? 'OMR' }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; color: #059669;">
            <span>{{ __('admin.paid') }}</span>
            <span style="font-weight: 700;">{{ number_format($invoice->paid_amount, 2) }}</span>
        </div>
        @if($invoice->remaining_amount > 0)
        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; color: #dc2626;">
            <span>{{ __('admin.remaining') }}</span>
            <span style="font-weight: 700;">{{ number_format($invoice->remaining_amount, 2) }}</span>
        </div>
        @endif
        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.8rem; color: #6b7280;">
            <span>{{ __('admin.payment_method') }}</span>
            <span>{{ __('admin.pay_' . $invoice->payment_method) }}</span>
        </div>
    </div>

    <!-- Add Payment (if partial) -->
    @if($invoice->remaining_amount > 0)
    <div style="background: #fffbeb; border-radius: 1rem; border: 1px solid #fbbf24; padding: 1.25rem; margin-bottom: 1rem;">
        <h3 style="font-size: 0.9rem; font-weight: 700; color: #92400e; margin-bottom: 0.75rem;">{{ __('admin.add_payment') }}</h3>
        <form method="POST" action="{{ route('invoice.add-payment', [$salon, $invoice]) }}" style="display: flex; gap: 0.75rem; align-items: end;">
            @csrf
            <div style="flex: 1;">
                <label style="font-size: 0.75rem; font-weight: 600; color: #374151;">{{ __('admin.amount') }}</label>
                <input type="number" name="amount" step="0.01" min="0.01" max="{{ $invoice->remaining_amount }}" required
                       style="width: 100%; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-size: 0.85rem; margin-top: 0.25rem;">
            </div>
            <button type="submit" style="padding: 0.5rem 1.25rem; background: #f59e0b; color: #fff; border: none; border-radius: 0.375rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                {{ __('admin.record_payment') }}
            </button>
        </form>
    </div>
    @endif

    <!-- Actions -->
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('invoice.index', $salon) }}" style="padding: 0.6rem 1.25rem; border: 1px solid #e5e7eb; border-radius: 0.625rem; text-decoration: none; font-size: 0.8rem; color: #6b7280;">
            <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
        </a>
        <button onclick="window.print()" style="padding: 0.6rem 1.25rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border: none; border-radius: 0.625rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
            <i class="fas fa-print"></i> {{ __('admin.print') }}
        </button>
    </div>
</div>
@endsection
