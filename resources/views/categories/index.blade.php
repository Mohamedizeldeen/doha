@extends('admin.layout.app')

@section('page-title', __('admin.categories'))

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-title { font-size: 1.25rem; font-weight: 800; color: #1a1a2e; display: flex; align-items: center; gap: 0.5rem; }
    .page-title i { color: #dd208e; }
    .btn-add { background: linear-gradient(135deg, #dd208e, #b01670); color: #fff; padding: 0.6rem 1.25rem; border-radius: 0.75rem; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; border: none; cursor: pointer; }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(221,32,142,0.3); }
    .category-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.25rem; }
    .category-card { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; transition: all 0.3s; position: relative; overflow: hidden; }
    .category-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .category-card::before { content: ''; position: absolute; top: 0; {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 0; width: 4px; height: 100%; background: linear-gradient(180deg, #dd208e, #9333ea); border-radius: 4px 0 0 4px; }
    .category-icon { width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, rgba(221,32,142,0.1), rgba(147,51,234,0.1)); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
    .category-icon i { font-size: 1.25rem; color: #dd208e; }
    .category-name { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 0.15rem; }
    .category-name-sub { font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.75rem; }
    .services-count { display: inline-flex; align-items: center; gap: 0.35rem; background: #f0f9ff; color: #0369a1; padding: 0.3rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
    .category-actions { display: flex; gap: 0.5rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; }
    .action-btn { flex: 1; padding: 0.5rem; border-radius: 0.625rem; text-align: center; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem; border: none; cursor: pointer; }
    .action-edit { background: #fef3c7; color: #92400e; }
    .action-edit:hover { background: #fde68a; }
    .action-delete { background: #fee2e2; color: #991b1b; }
    .action-delete:hover { background: #fecaca; }
    .empty-state { text-align: center; padding: 4rem 2rem; }
    .empty-icon { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, rgba(221,32,142,0.1), rgba(147,51,234,0.1)); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
    .empty-icon i { font-size: 2rem; color: #dd208e; }
    .empty-title { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 0.5rem; }
    .empty-text { font-size: 0.85rem; color: #94a3b8; margin-bottom: 1.5rem; }
</style>

<!-- Flash Messages -->
@if(session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.25rem; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="page-header">
    <h1 class="page-title"><i class="fas fa-layer-group"></i> {{ __('admin.categories') }}</h1>
    <a href="{{ route('category.create', $salon) }}" class="btn-add">
        <i class="fas fa-plus"></i> {{ __('admin.add_category') }}
    </a>
</div>

@if($categories->isEmpty())
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-layer-group"></i></div>
        <h3 class="empty-title">{{ __('admin.no_categories') }}</h3>
        <p class="empty-text">{{ app()->getLocale() === 'ar' ? 'ابدأ بإضافة فئات لتنظيم خدماتك' : 'Start by adding categories to organize your services' }}</p>
        <a href="{{ route('category.create', $salon) }}" class="btn-add">
            <i class="fas fa-plus"></i> {{ __('admin.add_category') }}
        </a>
    </div>
@else
    <div class="category-grid">
        @foreach($categories as $category)
            <div class="category-card">
                <div class="category-icon"><i class="fas fa-layer-group"></i></div>
                <div class="category-name">{{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}</div>
                <div class="category-name-sub">{{ app()->getLocale() === 'ar' ? $category->name_en : $category->name_ar }}</div>
                <div class="services-count">
                    <i class="fas fa-concierge-bell"></i>
                    {{ $category->services_count }} {{ __('admin.services') }}
                </div>
                <div class="category-actions">
                    <a href="{{ route('category.edit', [$salon, $category]) }}" class="action-btn action-edit">
                        <i class="fas fa-edit"></i> {{ __('admin.edit') }}
                    </a>
                    <form action="{{ route('category.destroy', [$salon, $category]) }}" method="POST" style="flex:1;" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn action-delete" style="width:100%;">
                            <i class="fas fa-trash"></i> {{ __('admin.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
