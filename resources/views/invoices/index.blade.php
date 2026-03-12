@extends('admin.layout.app')

@section('page-title', __('admin.invoices'))

@section('content')
<!-- Dashboard Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: linear-gradient(135deg, #fdf2f8, #fce7f3); border-radius: 1rem; padding: 1.25rem; border: 1px solid #fbcfe8;">
        <div style="font-size: 0.7rem; color: #9d174d; font-weight: 600; text-transform: uppercase;">{{ __('admin.today_revenue') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary); margin-top: 0.25rem;">{{ number_format($todayRevenue, 2) }}</div>
        <div style="font-size: 0.65rem; color: #be185d;">{{ $salon->currency ?? 'OMR' }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 1rem; padding: 1.25rem; border: 1px solid #bbf7d0;">
        <div style="font-size: 0.7rem; color: #166534; font-weight: 600; text-transform: uppercase;">{{ __('admin.month_revenue') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #059669; margin-top: 0.25rem;">{{ number_format($monthlyRevenue, 2) }}</div>
        <div style="font-size: 0.65rem; color: #16a34a;">{{ $salon->currency ?? 'OMR' }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 1rem; padding: 1.25rem; border: 1px solid #bfdbfe;">
        <div style="font-size: 0.7rem; color: #1e40af; font-weight: 600; text-transform: uppercase;">{{ __('admin.total_invoices') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #2563eb; margin-top: 0.25rem;">{{ $totalInvoices }}</div>
        <div style="font-size: 0.65rem; color: #3b82f6;">{{ __('admin.invoices') }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #fefce8, #fef3c7); border-radius: 1rem; padding: 1.25rem; border: 1px solid #fde68a;">
        <div style="font-size: 0.7rem; color: #92400e; font-weight: 600; text-transform: uppercase;">{{ __('admin.unpaid_amount') }}</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #d97706; margin-top: 0.25rem;">{{ number_format($unpaidAmount + $partialAmount, 2) }}</div>
        <div style="font-size: 0.65rem; color: #b45309;">{{ $salon->currency ?? 'OMR' }}</div>
    </div>
</div>

<!-- Header -->
<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; gap: 1rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.all_invoices') }}</h2>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('invoice.create', $salon) }}" style="padding: 0.6rem 1.25rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border-radius: 0.625rem; text-decoration: none; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-plus"></i> {{ __('admin.new_invoice') }}
        </a>
        <a href="{{ route('invoice.daily-sales', $salon) }}" style="padding: 0.6rem 1.25rem; border: 1px solid #e5e7eb; border-radius: 0.625rem; text-decoration: none; font-size: 0.8rem; color: #6b7280; background: #fff; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-receipt"></i> {{ __('admin.daily_sales') }}
        </a>
    </div>
</div>

<!-- Invoices Table -->
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 0.75rem 1rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">#</th>
                    <th style="padding: 0.75rem 1rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.client') }}</th>
                    <th style="padding: 0.75rem 1rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.total') }}</th>
                    <th style="padding: 0.75rem 1rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.paid') }}</th>
                    <th style="padding: 0.75rem 1rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.payment_method') }}</th>
                    <th style="padding: 0.75rem 1rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.status') }}</th>
                    <th style="padding: 0.75rem 1rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.date') }}</th>
                    <th style="padding: 0.75rem 1rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.75rem 1rem; font-size: 0.8rem; font-weight: 600; color: var(--primary);">{{ $invoice->invoice_number }}</td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.8rem; color: #374151;">
                        {{ $invoice->client ? (app()->getLocale() === 'ar' ? $invoice->client->name_ar : $invoice->client->name_en) : __('admin.walk_in_client') }}
                    </td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.8rem; font-weight: 700; color: #1f2937;">{{ number_format($invoice->total, 2) }}</td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.8rem; color: #059669; font-weight: 600;">{{ number_format($invoice->paid_amount, 2) }}</td>
                    <td style="padding: 0.75rem 1rem;">
                        <span style="font-size: 0.7rem; padding: 0.2rem 0.5rem; border-radius: 9999px; background: #f3f4f6; color: #374151;">
                            {{ __('admin.pay_' . $invoice->payment_method) }}
                        </span>
                    </td>
                    <td style="padding: 0.75rem 1rem;">
                        @php
                            $statusStyles = [
                                'paid' => 'background: #dcfce7; color: #166534;',
                                'partial' => 'background: #fef3c7; color: #92400e;',
                                'unpaid' => 'background: #fee2e2; color: #991b1b;',
                                'refunded' => 'background: #f3f4f6; color: #6b7280;',
                            ];
                        @endphp
                        <span style="font-size: 0.7rem; padding: 0.2rem 0.5rem; border-radius: 9999px; {{ $statusStyles[$invoice->status] ?? '' }}">
                            {{ __('admin.inv_' . $invoice->status) }}
                        </span>
                    </td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.75rem; color: #6b7280;">{{ $invoice->created_at->format('d/m/Y H:i') }}</td>
                    <td style="padding: 0.75rem 1rem; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <a href="{{ route('invoice.show', [$salon, $invoice]) }}" style="color: var(--primary); font-size: 0.85rem;" title="{{ __('admin.view') }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <form action="{{ route('invoice.destroy', [$salon, $invoice]) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.85rem; padding: 0;" title="{{ __('admin.delete') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 3rem; text-align: center; color: #9ca3af; font-size: 0.85rem;">
                        <i class="fas fa-file-invoice" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                        {{ __('admin.no_invoices') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($invoices->hasPages())
    <div style="padding: 1rem; border-top: 1px solid #e5e7eb;">
        {{ $invoices->links() }}
    </div>
    @endif
</div>
@endsection
