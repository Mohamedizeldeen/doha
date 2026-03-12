@extends('admin.layout.app')

@section('page-title', __('admin.vat_report'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
    <div>
        <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.vat_report') }}</h2>
        <p style="font-size: 0.8rem; color: #6b7280;">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }} — Q{{ $quarter }}</p>
    </div>
    <form method="GET" action="{{ route('reports.vat', $salon) }}" style="display: flex; gap: 0.5rem; align-items: center;">
        <input type="month" name="month" value="{{ $month }}" style="padding: 0.4rem 0.6rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.8rem;">
        <button type="submit" style="padding: 0.4rem 0.8rem; background: var(--primary); color: #fff; border: none; border-radius: 0.5rem; font-size: 0.8rem; cursor: pointer;">
            <i class="fas fa-filter"></i>
        </button>
    </form>
</div>

<!-- Monthly VAT Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background: linear-gradient(135deg, #059669, #34d399); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.85;"><i class="fas fa-receipt"></i> {{ __('admin.total_sales') }}</div>
        <div style="font-size: 1.4rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($totalSales, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #dc2626, #f87171); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.85;"><i class="fas fa-arrow-up"></i> {{ __('admin.output_vat') }}</div>
        <div style="font-size: 1.4rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($outputVat, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, #7c3aed, #a78bfa); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.85;"><i class="fas fa-arrow-down"></i> {{ __('admin.input_vat') }}</div>
        <div style="font-size: 1.4rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($inputVat, 2) }} {{ $currency }}</div>
    </div>
    <div style="background: linear-gradient(135deg, {{ $netVat >= 0 ? '#f59e0b, #fbbf24' : '#059669, #34d399' }}); border-radius: 1rem; padding: 1.25rem; color: #fff;">
        <div style="font-size: 0.7rem; opacity: 0.85;"><i class="fas fa-balance-scale"></i> {{ __('admin.net_vat') }}</div>
        <div style="font-size: 1.4rem; font-weight: 800; margin-top: 0.25rem;">{{ number_format($netVat, 2) }} {{ $currency }}</div>
        <div style="font-size: 0.65rem; opacity: 0.8; margin-top: 0.15rem;">{{ $netVat >= 0 ? __('admin.vat_payable') : __('admin.vat_refundable') }}</div>
    </div>
</div>

<!-- VAT Calculation Table -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
    <!-- Output VAT Details -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
        <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
            <i class="fas fa-file-invoice" style="color: #059669;"></i> {{ __('admin.output_vat_details') }}
        </h3>
        <p style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.75rem;">{{ __('admin.vat_collected_from_sales') }}</p>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 0.4rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.invoice') }}</th>
                    <th style="padding: 0.4rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.subtotal') }}</th>
                    <th style="padding: 0.4rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.vat') }}</th>
                    <th style="padding: 0.4rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices->take(10) as $inv)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.4rem; font-size: 0.75rem; color: #374151;">#{{ $inv->id }}</td>
                    <td style="padding: 0.4rem; font-size: 0.75rem; text-align: center; color: #374151;">{{ number_format($inv->subtotal, 2) }}</td>
                    <td style="padding: 0.4rem; font-size: 0.75rem; text-align: center; color: #dc2626; font-weight: 600;">{{ number_format($inv->tax_amount, 2) }}</td>
                    <td style="padding: 0.4rem; font-size: 0.75rem; text-align: center; color: #374151;">{{ number_format($inv->total, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="padding: 1rem; text-align: center; color: #9ca3af; font-size: 0.75rem;">{{ __('admin.no_data') }}</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="border-top: 2px solid #374151;">
                    <td style="padding: 0.5rem; font-size: 0.8rem; font-weight: 800;">{{ __('admin.total') }}</td>
                    <td style="padding: 0.5rem; font-size: 0.8rem; text-align: center; font-weight: 700;">{{ number_format($totalSales, 2) }}</td>
                    <td style="padding: 0.5rem; font-size: 0.8rem; text-align: center; font-weight: 700; color: #dc2626;">{{ number_format($outputVat, 2) }}</td>
                    <td style="padding: 0.5rem; font-size: 0.8rem; text-align: center; font-weight: 700;">{{ number_format($totalWithVat, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Input VAT Details -->
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
        <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
            <i class="fas fa-file-invoice-dollar" style="color: #7c3aed;"></i> {{ __('admin.input_vat_details') }}
        </h3>
        <p style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.75rem;">{{ __('admin.vat_paid_on_expenses') }}</p>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 0.4rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.expense') }}</th>
                    <th style="padding: 0.4rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.amount') }}</th>
                    <th style="padding: 0.4rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.vat_rate') }}</th>
                    <th style="padding: 0.4rem; font-size: 0.65rem; font-weight: 600; color: #6b7280; text-align: center;">{{ __('admin.vat') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expensesWithVat->take(10) as $exp)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.4rem; font-size: 0.75rem; color: #374151;">{{ Str::limit($exp->description, 30) }}</td>
                    <td style="padding: 0.4rem; font-size: 0.75rem; text-align: center; color: #374151;">{{ number_format($exp->amount, 2) }}</td>
                    <td style="padding: 0.4rem; font-size: 0.75rem; text-align: center; color: #374151;">{{ $exp->vat_rate }}%</td>
                    <td style="padding: 0.4rem; font-size: 0.75rem; text-align: center; color: #7c3aed; font-weight: 600;">{{ number_format($exp->vat_amount, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="padding: 1rem; text-align: center; color: #9ca3af; font-size: 0.75rem;">{{ __('admin.no_data') }}</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="border-top: 2px solid #374151;">
                    <td colspan="3" style="padding: 0.5rem; font-size: 0.8rem; font-weight: 800;">{{ __('admin.total_input_vat') }}</td>
                    <td style="padding: 0.5rem; font-size: 0.8rem; text-align: center; font-weight: 700; color: #7c3aed;">{{ number_format($inputVat, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Quarterly Summary -->
<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
    <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
        <i class="fas fa-calendar-alt" style="color: #f59e0b;"></i> {{ __('admin.quarterly_vat_summary') }} — Q{{ $quarter }}
    </h3>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
        <div style="background: #f0fdf4; border-radius: 0.75rem; padding: 1rem; text-align: center;">
            <div style="font-size: 0.7rem; color: #166534;">{{ __('admin.output_vat') }} (Q{{ $quarter }})</div>
            <div style="font-size: 1.25rem; font-weight: 800; color: #059669;">{{ number_format($quarterOutputVat, 2) }}</div>
        </div>
        <div style="background: #faf5ff; border-radius: 0.75rem; padding: 1rem; text-align: center;">
            <div style="font-size: 0.7rem; color: #6b21a8;">{{ __('admin.input_vat') }} (Q{{ $quarter }})</div>
            <div style="font-size: 1.25rem; font-weight: 800; color: #7c3aed;">{{ number_format($quarterInputVat, 2) }}</div>
        </div>
        <div style="background: {{ $quarterNetVat >= 0 ? '#fffbeb' : '#f0fdf4' }}; border-radius: 0.75rem; padding: 1rem; text-align: center;">
            <div style="font-size: 0.7rem; color: {{ $quarterNetVat >= 0 ? '#92400e' : '#166534' }};">{{ __('admin.net_vat') }} (Q{{ $quarter }})</div>
            <div style="font-size: 1.25rem; font-weight: 800; color: {{ $quarterNetVat >= 0 ? '#f59e0b' : '#059669' }};">{{ number_format($quarterNetVat, 2) }} {{ $currency }}</div>
            <div style="font-size: 0.65rem; color: #6b7280; margin-top: 0.15rem;">{{ $quarterNetVat >= 0 ? __('admin.vat_payable') : __('admin.vat_refundable') }}</div>
        </div>
    </div>
</div>
@endsection
