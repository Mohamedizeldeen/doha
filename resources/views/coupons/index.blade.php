@extends('admin.layout.app')

@section('page-title', __('admin.coupons'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.coupons') }}</h2>
    <a href="{{ route('coupon.create', $salon) }}" style="padding: 0.5rem 1rem; background: var(--primary); color: #fff; border-radius: 0.75rem; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
        <i class="fas fa-plus"></i> {{ __('admin.add_coupon') }}
    </a>
</div>

@if(session('success'))
<div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.85rem;">
    {{ session('success') }}
</div>
@endif

<div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.code') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.type') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.value') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.usage') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.valid_until') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ __('admin.status') }}</th>
                <th style="padding: 0.75rem; font-size: 0.7rem; font-weight: 600; color: #6b7280;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 0.75rem;">
                    <span style="font-family: monospace; font-size: 0.85rem; font-weight: 700; color: var(--primary); background: #fdf2f8; padding: 0.2rem 0.5rem; border-radius: 0.25rem;">{{ $coupon->code }}</span>
                </td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #374151;">
                    {{ $coupon->type === 'percentage' ? __('admin.percentage') : __('admin.fixed_amount') }}
                </td>
                <td style="padding: 0.75rem; font-size: 0.85rem; font-weight: 700; color: #1f2937;">
                    {{ $coupon->type === 'percentage' ? $coupon->value . '%' : number_format($coupon->value, 2) }}
                </td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #6b7280;">
                    {{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }}
                </td>
                <td style="padding: 0.75rem; font-size: 0.8rem; color: #6b7280;">
                    {{ $coupon->valid_until ? $coupon->valid_until->format('d/m/Y') : __('admin.unlimited') }}
                </td>
                <td style="padding: 0.75rem;">
                    @if($coupon->isValid())
                    <span style="font-size: 0.65rem; padding: 0.15rem 0.4rem; background: #dcfce7; color: #166534; border-radius: 9999px;">{{ __('admin.active') }}</span>
                    @else
                    <span style="font-size: 0.65rem; padding: 0.15rem 0.4rem; background: #fee2e2; color: #991b1b; border-radius: 9999px;">{{ __('admin.expired') }}</span>
                    @endif
                </td>
                <td style="padding: 0.75rem;">
                    <form action="{{ route('coupon.destroy', [$salon, $coupon]) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                        @csrf @method('DELETE')
                        <button type="submit" style="padding: 0.25rem 0.5rem; color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.75rem;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding: 3rem; text-align: center; color: #9ca3af; font-size: 0.85rem;">
                    {{ __('admin.no_coupons') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
