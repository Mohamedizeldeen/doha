@extends('admin.layout.app')

@section('page-title', __('admin.packages'))

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: #1f2937;">{{ __('admin.packages') }}</h2>
    <a href="{{ route('package.create', $salon) }}" style="padding: 0.5rem 1rem; background: var(--primary); color: #fff; border-radius: 0.75rem; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
        <i class="fas fa-plus"></i> {{ __('admin.add_package') }}
    </a>
</div>

@if(session('success'))
<div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.85rem;">
    {{ session('success') }}
</div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
    @forelse($packages as $package)
    <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; overflow: hidden; display: flex; flex-direction: column;">
        <div style="padding: 1.25rem; flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #1f2937;">
                    {{ app()->getLocale() === 'ar' ? $package->name_ar : $package->name_en }}
                </h3>
                @if($package->isValid())
                <span style="font-size: 0.65rem; padding: 0.1rem 0.4rem; background: #dcfce7; color: #166534; border-radius: 9999px;">{{ __('admin.active') }}</span>
                @else
                <span style="font-size: 0.65rem; padding: 0.1rem 0.4rem; background: #fee2e2; color: #991b1b; border-radius: 9999px;">{{ __('admin.expired') }}</span>
                @endif
            </div>

            @if($package->description_ar || $package->description_en)
            <p style="font-size: 0.8rem; color: #6b7280; margin-bottom: 0.75rem;">
                {{ app()->getLocale() === 'ar' ? $package->description_ar : $package->description_en }}
            </p>
            @endif

            <div style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem;">
                <div style="text-align: center;">
                    <span style="font-size: 0.65rem; color: #9ca3af;">{{ __('admin.original_price') }}</span>
                    <div style="font-size: 0.85rem; color: #6b7280; text-decoration: line-through;">{{ number_format($package->original_price, 2) }}</div>
                </div>
                <div style="text-align: center;">
                    <span style="font-size: 0.65rem; color: #9ca3af;">{{ __('admin.price') }}</span>
                    <div style="font-size: 1rem; font-weight: 800; color: var(--primary);">{{ number_format($package->price, 2) }}</div>
                </div>
                <div style="text-align: center;">
                    <span style="font-size: 0.65rem; color: #9ca3af;">{{ __('admin.discount') }}</span>
                    <div style="font-size: 0.85rem; font-weight: 700; color: #059669;">{{ $package->getDiscountPercentage() }}%</div>
                </div>
            </div>

            <div style="margin-bottom: 0.5rem;">
                <span style="font-size: 0.7rem; font-weight: 600; color: #6b7280;">{{ __('admin.services') }} ({{ $package->services->count() }}):</span>
                <div style="display: flex; flex-wrap: wrap; gap: 0.25rem; margin-top: 0.25rem;">
                    @foreach($package->services as $service)
                    <span style="font-size: 0.65rem; padding: 0.15rem 0.4rem; background: #f3f4f6; border-radius: 0.25rem; color: #374151;">
                        {{ app()->getLocale() === 'ar' ? $service->name_ar : $service->name_en }}
                    </span>
                    @endforeach
                </div>
            </div>

            @if($package->valid_from || $package->valid_until)
            <div style="font-size: 0.7rem; color: #9ca3af;">
                <i class="fas fa-calendar"></i>
                {{ $package->valid_from ? $package->valid_from->format('d/m/Y') : '' }} -
                {{ $package->valid_until ? $package->valid_until->format('d/m/Y') : __('admin.unlimited') }}
            </div>
            @endif
        </div>

        <div style="padding: 0.75rem 1.25rem; border-top: 1px solid #f3f4f6; display: flex; gap: 0.5rem;">
            <a href="{{ route('package.edit', [$salon, $package]) }}" style="flex: 1; text-align: center; padding: 0.4rem; background: #f3f4f6; border-radius: 0.375rem; color: #374151; text-decoration: none; font-size: 0.75rem;">
                <i class="fas fa-edit"></i> {{ __('admin.edit') }}
            </a>
            <form action="{{ route('package.destroy', [$salon, $package]) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')" style="flex: 1;">
                @csrf @method('DELETE')
                <button type="submit" style="width: 100%; padding: 0.4rem; background: #fef2f2; border: none; border-radius: 0.375rem; color: #ef4444; cursor: pointer; font-size: 0.75rem;">
                    <i class="fas fa-trash"></i> {{ __('admin.delete') }}
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #9ca3af;">
        <i class="fas fa-box-open" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <p>{{ __('admin.no_packages') }}</p>
    </div>
    @endforelse
</div>
@endsection
