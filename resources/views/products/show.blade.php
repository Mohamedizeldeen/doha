@extends('admin.layout.app')

@section('page-title', 'تفاصيل المنتج')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ $product->name_ar }}</h2>
    <div class="flex gap-3">
        <a href="{{ route('product.edit', [$salon, $product]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-edit ml-2"></i>تعديل
        </a>
        <a href="{{ route('product.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition">
            <i class="fas fa-arrow-right ml-2"></i>رجوع
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Product Image -->
            @if ($product->image)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_ar }}" class="w-full max-h-96 object-cover rounded-lg">
                </div>
            @else
                <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg mb-6">
                    <i class="fas fa-box text-6xl text-gray-400"></i>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-sm font-medium text-gray-600 mb-2">الاسم (عربي)</h3>
                    <p class="text-xl font-bold text-gray-800">{{ $product->name_ar }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-600 mb-2">Product Name (English)</h3>
                    <p class="text-xl font-bold text-gray-800">{{ $product->name_en }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-600 mb-2">السعر</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $product->price }} {{ $salon->currency }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-600 mb-2">المخزون</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $product->stock_quantity }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-600 mb-2">الحالة</h3>
                    <span class="text-lg px-4 py-2 rounded-full {{ $product->isInStock() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->getStockStatus() === 'in_stock' ? 'متوفر' : 'غير متوفر' }}
                    </span>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-600 mb-2">التاريخ</h3>
                    <p class="text-gray-800">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            @if ($product->description_ar || $product->description_en)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">الوصف</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($product->description_ar)
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">عربي</h4>
                                <p class="text-gray-600">{{ $product->description_ar }}</p>
                            </div>
                        @endif
                        @if ($product->description_en)
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">English</h4>
                                <p class="text-gray-600">{{ $product->description_en }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Stock Management -->
    <div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">إدارة المخزون</h3>
            
            <div class="mb-6 p-4 rounded-lg bg-blue-50">
                <p class="text-sm text-gray-600 mb-1">الكمية الحالية</p>
                <p class="text-3xl font-bold text-blue-600">{{ $product->stock_quantity }}</p>
            </div>

            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">الحالة:</span>
                    <span class="font-bold {{ $product->isInStock() ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->isInStock() ? 'متوفر' : 'غير متوفر' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">السعر (للقطعة):</span>
                    <span class="font-bold text-green-600">{{ $product->price }} {{ $salon->currency }}</span>
                </div>
                <div class="flex justify-between border-t pt-2 mt-2">
                    <span class="text-gray-600">القيمة الإجمالية:</span>
                    <span class="font-bold text-purple-600">{{ $product->price * $product->stock_quantity }} {{ $salon->currency }}</span>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t">
                <p class="text-xs text-gray-500 text-center">لتعديل المخزون، استخدم زر التعديل</p>
            </div>
        </div>
    </div>
</div>
@endsection
