@extends('admin.layout.app')

@section('page-title', __('admin.products'))

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-title { font-size: 1.25rem; font-weight: 800; color: #1a1a2e; display: flex; align-items: center; gap: 0.5rem; }
    .page-title i { color: #dd208e; }
    .btn-add { background: linear-gradient(135deg, #dd208e, #b01670); color: #fff; padding: 0.6rem 1.25rem; border-radius: 0.75rem; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; border: none; cursor: pointer; }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(221,32,142,0.3); }
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.25rem; }
    .product-card { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; transition: all 0.3s; }
    .product-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .product-img { width: 100%; height: 200px; object-fit: cover; }
    .product-img-placeholder { width: 100%; height: 200px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); display: flex; align-items: center; justify-content: center; }
    .product-img-placeholder i { font-size: 3rem; color: #cbd5e1; }
    .product-body { padding: 1.25rem; }
    .product-name { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 0.25rem; line-height: 1.3; }
    .product-name-sub { font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.5rem; }
    .product-desc { font-size: 0.8rem; color: #64748b; line-height: 1.5; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .product-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0.75rem; background: #f8fafc; border-radius: 0.75rem; }
    .product-price { font-size: 1.25rem; font-weight: 800; color: #dd208e; }
    .product-price small { font-size: 0.7rem; color: #94a3b8; font-weight: 500; }
    .stock-badge { padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
    .stock-in { background: #dcfce7; color: #166534; }
    .stock-out { background: #fee2e2; color: #991b1b; }
    .product-stock { font-size: 0.8rem; color: #64748b; display: flex; align-items: center; gap: 0.35rem; }
    .product-actions { display: flex; gap: 0.5rem; border-top: 1px solid #f1f5f9; padding-top: 1rem; }
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
</style>

<div class="page-header">
    <div class="page-title"><i class="fas fa-box"></i> {{ __('admin.products') }}</div>
    <a href="{{ route('product.create', $salon) }}" class="btn-add">
        <i class="fas fa-plus"></i> {{ __('admin.add_product') }}
    </a>
</div>

@if (session('success'))
    <div class="toast-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="product-grid">
    @forelse ($products as $product)
        <div class="product-card">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="" class="product-img">
            @else
                <div class="product-img-placeholder"><i class="fas fa-box-open"></i></div>
            @endif

            <div class="product-body">
                <div class="product-name">{{ app()->getLocale() === 'ar' ? $product->name_ar : ($product->name_en ?? $product->name_ar) }}</div>
                @if(app()->getLocale() === 'ar' && $product->name_en)
                    <div class="product-name-sub">{{ $product->name_en }}</div>
                @elseif(app()->getLocale() !== 'ar' && $product->name_ar)
                    <div class="product-name-sub">{{ $product->name_ar }}</div>
                @endif

                @if ($product->description_ar || $product->description_en)
                    <div class="product-desc">{{ app()->getLocale() === 'ar' ? $product->description_ar : ($product->description_en ?? $product->description_ar) }}</div>
                @endif

                <div class="product-meta">
                    <div>
                        <div class="product-price">{{ number_format($product->price, 2) }} <small>{{ $salon->currency }}</small></div>
                    </div>
                    <div style="text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                        <span class="stock-badge {{ $product->isInStock() ? 'stock-in' : 'stock-out' }}">
                            {{ $product->getStockStatus() === 'in_stock' ? __('admin.in_stock') : __('admin.out_of_stock') }}
                        </span>
                        <div class="product-stock" style="margin-top: 0.35rem; justify-content: flex-end;">
                            <i class="fas fa-cubes"></i> {{ $product->stock_quantity }}
                        </div>
                    </div>
                </div>

                <div class="product-actions">
                    <a href="{{ route('product.edit', [$salon, $product]) }}" class="action-btn action-edit">
                        <i class="fas fa-pen"></i> {{ __('admin.edit') }}
                    </a>
                    <a href="{{ route('product.show', [$salon, $product]) }}" class="action-btn action-view">
                        <i class="fas fa-eye"></i> {{ __('admin.view') }}
                    </a>
                    <form method="POST" action="{{ route('product.destroy', [$salon, $product]) }}" style="flex: 1; margin: 0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn action-delete" style="width: 100%;" onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                            <i class="fas fa-trash"></i> {{ __('admin.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <p>{{ __('admin.no_products') }}</p>
            <a href="{{ route('product.create', $salon) }}" class="btn-add" style="margin-top: 1rem; display: inline-flex;">
                <i class="fas fa-plus"></i> {{ __('admin.add_product') }}
            </a>
        </div>
    @endforelse
</div>
@endsection
