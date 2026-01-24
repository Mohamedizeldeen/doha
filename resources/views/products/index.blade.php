@extends('admin.layout.app')

@section('page-title', 'المنتجات')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">المنتجات</h2>
    <a href="{{ route('product.create', $salon) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
        <i class="fas fa-plus ml-2"></i>إضافة منتج
    </a>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($products as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_ar }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-box text-4xl text-gray-400"></i>
                </div>
            @endif

            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name_ar }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ $product->name_en }}</p>
                
                @if ($product->description_ar)
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $product->description_ar }}</p>
                @endif

                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $product->price }} ريال</p>
                    </div>
                    <div>
                        <span class="text-xs px-3 py-1 rounded-full {{ $product->isInStock() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->getStockStatus() }}
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600">المخزون: <span class="font-bold">{{ $product->stock_quantity }}</span></p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('product.edit', [$salon, $product]) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-3 rounded text-center transition text-sm">
                        <i class="fas fa-edit ml-1"></i>تعديل
                    </a>
                    <a href="{{ route('product.show', [$salon, $product]) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded text-center transition text-sm">
                        <i class="fas fa-eye ml-1"></i>عرض
                    </a>
                    <form method="POST" action="{{ route('product.destroy', [$salon, $product]) }}" style="display:inline; flex: 1;">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded transition text-sm" onclick="return confirm('هل أنت متأكد؟')">
                            <i class="fas fa-trash ml-1"></i>حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12 bg-white rounded-lg">
            <p class="text-gray-600 text-lg">لا توجد منتجات حالياً</p>
        </div>
    @endforelse
</div>
@endsection
