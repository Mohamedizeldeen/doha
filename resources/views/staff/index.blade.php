@extends('admin.layout.app')

@section('page-title', __('admin.staff_list'))

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-title { font-size: 1.25rem; font-weight: 800; color: #1a1a2e; display: flex; align-items: center; gap: 0.5rem; }
    .page-title i { color: #dd208e; }
    .btn-add { background: linear-gradient(135deg, #dd208e, #b01670); color: #fff; padding: 0.6rem 1.25rem; border-radius: 0.75rem; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; border: none; cursor: pointer; }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(221,32,142,0.3); }
    .staff-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.25rem; }
    .staff-card { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; transition: all 0.3s; }
    .staff-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .staff-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .staff-avatar { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #fdf2f8, #fce7f3); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #dd208e; font-weight: 700; flex-shrink: 0; }
    .staff-name { font-size: 1.05rem; font-weight: 700; color: #1a1a2e; }
    .staff-position { font-size: 0.8rem; color: #dd208e; font-weight: 500; margin-top: 0.1rem; }
    .staff-name-sub { font-size: 0.78rem; color: #94a3b8; }
    .staff-details { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 1rem; }
    .staff-detail { background: #f8fafc; border-radius: 0.625rem; padding: 0.65rem 0.85rem; }
    .staff-detail-label { font-size: 0.65rem; color: #94a3b8; font-weight: 500; margin-bottom: 0.1rem; text-transform: uppercase; letter-spacing: 0.03em; }
    .staff-detail-value { font-size: 0.85rem; color: #334155; font-weight: 600; word-break: break-all; }
    .staff-detail-value a { color: #dd208e; text-decoration: none; }
    .staff-actions { display: flex; gap: 0.5rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; }
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
    @media (max-width: 768px) { .staff-grid { grid-template-columns: 1fr; } .staff-details { grid-template-columns: 1fr; } }
</style>

<div class="page-header">
    <div class="page-title"><i class="fas fa-users"></i> {{ __('admin.staff_list') }}</div>
    <a href="{{ route('staff.create', $salon) }}" class="btn-add">
        <i class="fas fa-plus"></i> {{ __('admin.add_staff') }}
    </a>
</div>

@if (session('success'))
    <div class="toast-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="staff-grid">
    @forelse ($staff as $member)
        <div class="staff-card">
            <div class="staff-header">
                <div class="staff-avatar">
                    {{ mb_substr(app()->getLocale() === 'ar' ? $member->name_ar : ($member->name_en ?? $member->name_ar), 0, 1) }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div class="staff-name">{{ app()->getLocale() === 'ar' ? $member->name_ar : ($member->name_en ?? $member->name_ar) }}</div>
                    @if(app()->getLocale() === 'ar' && $member->name_en)
                        <div class="staff-name-sub">{{ $member->name_en }}</div>
                    @elseif(app()->getLocale() !== 'ar' && $member->name_ar)
                        <div class="staff-name-sub">{{ $member->name_ar }}</div>
                    @endif
                    <div class="staff-position">{{ app()->getLocale() === 'ar' ? $member->position_ar : ($member->position_en ?? $member->position_ar) }}</div>
                </div>
            </div>

            <div class="staff-details">
                <div class="staff-detail">
                    <div class="staff-detail-label">{{ __('admin.email') }}</div>
                    <div class="staff-detail-value"><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></div>
                </div>
                <div class="staff-detail">
                    <div class="staff-detail-label">{{ __('admin.phone') }}</div>
                    <div class="staff-detail-value" dir="ltr">{{ $member->phone }}</div>
                </div>
                <div class="staff-detail" style="grid-column: 1 / -1;">
                    <div class="staff-detail-label">{{ __('admin.services') }}</div>
                    <div class="staff-detail-value" style="color: #dd208e;">{{ $member->services->count() }} {{ __('admin.service') }}</div>
                </div>
            </div>

            <div class="staff-actions">
                <a href="{{ route('staff.edit', [$salon, $member]) }}" class="action-btn action-edit">
                    <i class="fas fa-pen"></i> {{ __('admin.edit') }}
                </a>
                <a href="{{ route('staff.show', [$salon, $member]) }}" class="action-btn action-view">
                    <i class="fas fa-eye"></i> {{ __('admin.view') }}
                </a>
                <form method="POST" action="{{ route('staff.destroy', [$salon, $member]) }}" style="flex: 1; margin: 0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-btn action-delete" style="width: 100%;" onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                        <i class="fas fa-trash"></i> {{ __('admin.delete') }}
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <p>{{ __('admin.no_data') }}</p>
            <a href="{{ route('staff.create', $salon) }}" class="btn-add" style="margin-top: 1rem; display: inline-flex;">
                <i class="fas fa-plus"></i> {{ __('admin.add_staff') }}
            </a>
        </div>
    @endforelse
</div>
@endsection
