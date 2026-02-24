@extends('admin.layout.app')

@section('page-title', __('admin.services'))

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-title { font-size: 1.25rem; font-weight: 800; color: #1a1a2e; display: flex; align-items: center; gap: 0.5rem; }
    .page-title i { color: #dd208e; }
    .btn-add { background: linear-gradient(135deg, #dd208e, #b01670); color: #fff; padding: 0.6rem 1.25rem; border-radius: 0.75rem; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; border: none; cursor: pointer; }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(221,32,142,0.3); }
    .service-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.25rem; }
    .service-card { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; transition: all 0.3s; position: relative; overflow: hidden; }
    .service-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .service-card::before { content: ''; position: absolute; top: 0; {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 0; width: 4px; height: 100%; background: linear-gradient(180deg, #dd208e, #9333ea); border-radius: 4px 0 0 4px; }
    .service-name { font-size: 1.05rem; font-weight: 700; color: #1a1a2e; margin-bottom: 0.15rem; }
    .service-name-sub { font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.75rem; }
    .service-info { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 0.75rem; }
    .service-info-item { background: #f8fafc; border-radius: 0.625rem; padding: 0.75rem; }
    .service-info-label { font-size: 0.7rem; color: #94a3b8; font-weight: 500; margin-bottom: 0.15rem; }
    .service-info-value { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; }
    .service-info-value.price { color: #dd208e; }
    .service-desc { font-size: 0.8rem; color: #64748b; line-height: 1.5; margin-bottom: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .status-badge { padding: 0.2rem 0.65rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
    .status-active { background: #dcfce7; color: #166534; }
    .status-inactive { background: #fee2e2; color: #991b1b; }
    .service-actions { display: flex; gap: 0.5rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; }
    .action-btn { flex: 1; padding: 0.5rem; border-radius: 0.625rem; text-align: center; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem; border: none; cursor: pointer; }
    .action-edit { background: #fef3c7; color: #92400e; }
    .action-edit:hover { background: #fde68a; }
    .action-view { background: #dbeafe; color: #1e40af; }
    .action-view:hover { background: #bfdbfe; }
    .action-delete { background: #fee2e2; color: #991b1b; }
    .action-delete:hover { background: #fecaca; }
    .empty-state { grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); }
    .empty-state i { font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem; display: block; }
    .empty-state p { color: #94a3b8; font-size: 0.95rem; }
    .toast-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.85rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.25rem; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; }
    @media (max-width: 768px) { .service-grid { grid-template-columns: 1fr; } }
</style>

<div class="page-header">
    <div class="page-title"><i class="fas fa-concierge-bell"></i> {{ __('admin.services') }}</div>
    <a href="{{ route('service.create', $salon) }}" class="btn-add">
        <i class="fas fa-plus"></i> {{ __('admin.add_service') }}
    </a>
</div>

@if (session('success'))
    <div class="toast-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="service-grid">
    @forelse ($services as $service)
        <div class="service-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                <div style="flex: 1;">
                    <div class="service-name">{{ app()->getLocale() === 'ar' ? $service->name_ar : ($service->name_en ?? $service->name_ar) }}</div>
                    @if(app()->getLocale() === 'ar' && $service->name_en)
                        <div class="service-name-sub">{{ $service->name_en }}</div>
                    @elseif(app()->getLocale() !== 'ar' && $service->name_ar)
                        <div class="service-name-sub">{{ $service->name_ar }}</div>
                    @endif
                </div>
                <span class="status-badge {{ $service->is_active ? 'status-active' : 'status-inactive' }}">
                    {{ $service->is_active ? __('admin.active') : __('admin.inactive') }}
                </span>
            </div>

            @if ($service->description_ar || $service->description_en)
                <div class="service-desc">{{ app()->getLocale() === 'ar' ? $service->description_ar : ($service->description_en ?? $service->description_ar) }}</div>
            @endif

            <div class="service-info">
                <div class="service-info-item">
                    <div class="service-info-label">{{ __('admin.price') }}</div>
                    <div class="service-info-value price">{{ number_format($service->price, 2) }} <span style="font-size: 0.7rem; font-weight: 500; color: #94a3b8;">{{ $salon->currency ?? '' }}</span></div>
                </div>
                <div class="service-info-item">
                    <div class="service-info-label">{{ __('admin.duration') }}</div>
                    <div class="service-info-value"><i class="fas fa-clock" style="font-size: 0.8rem; color: #94a3b8; margin-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 0.3rem;"></i>{{ $service->duration_minutes }} {{ __('admin.minutes') }}</div>
                </div>
            </div>

            <div class="service-actions">
                <a href="{{ route('service.edit', [$salon, $service]) }}" class="action-btn action-edit">
                    <i class="fas fa-pen"></i> {{ __('admin.edit') }}
                </a>
                <a href="{{ route('service.show', [$salon, $service]) }}" class="action-btn action-view">
                    <i class="fas fa-eye"></i> {{ __('admin.view') }}
                </a>
                <form method="POST" action="{{ route('service.destroy', [$salon, $service]) }}" style="flex: 1; margin: 0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-btn action-delete" style="width: 100%;" onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                        <i class="fas fa-trash"></i> {{ __('admin.delete') }}
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-concierge-bell"></i>
            <p>{{ __('admin.no_data') }}</p>
            <a href="{{ route('service.create', $salon) }}" class="btn-add" style="margin-top: 1rem; display: inline-flex;">
                <i class="fas fa-plus"></i> {{ __('admin.add_service') }}
            </a>
        </div>
    @endforelse
</div>
@endsection
