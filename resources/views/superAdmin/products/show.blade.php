@extends('superAdmin.layout.app')

@section('page-title', __('admin.product_details'))

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Product Header -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ app()->getLocale() === 'ar' ? $product->name_ar : ($product->name_en ?? $product->name_ar) }}</h1>
                <p class="text-gray-600 mt-2">{{ $product->name_en }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('superAdmin.products.edit', $product->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    {{ __('admin.edit') }}
                </a>
                <form action="{{ route('superAdmin.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ __('admin.confirm_delete_product') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        {{ __('admin.delete') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Product Image -->
            <div class="md:col-span-1">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ app()->getLocale() === 'ar' ? $product->name_ar : ($product->name_en ?? $product->name_ar) }}" class="w-full h-auto rounded-lg object-cover">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">{{ __('admin.no_image') }}</span>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="md:col-span-2 space-y-4">
                <!-- Salon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.salon') }}</label>
                    <a href="{{ route('superAdmin.salons.show', $product->salon->id) }}" class="text-lg text-blue-600 hover:text-blue-700 font-semibold">
                        {{ app()->getLocale() === 'ar' ? $product->salon->name_ar : ($product->salon->name_en ?? $product->salon->name_ar) }}
                    </a>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.price') }}</label>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format($product->price, 2) }} <span class="text-lg">{{ $product->salon->currency }}</span>
                    </p>
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.stock') }}</label>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-gray-900">{{ $product->stock_quantity }}</span>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                            @if($product->stock_quantity > 5) bg-green-100 text-green-700
                            @elseif($product->stock_quantity > 0) bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            @if($product->stock_quantity > 5) {{ __('admin.in_stock') }}
                            @elseif($product->stock_quantity > 0) {{ __('admin.low_stock') }}
                            @else {{ __('admin.out_of_stock') }} @endif
                        </span>
                    </div>
                </div>

                <!-- Created Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.created_at') }}</label>
                    <p class="text-gray-600">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <!-- Updated Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.last_update') }}</label>
                    <p class="text-gray-600">{{ $product->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Descriptions -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('admin.description') }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Arabic Description -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('admin.description_in_arabic') }}</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ app()->getLocale() === 'ar' ? $product->description_ar : ($product->description_en ?? $product->description_ar) }}</p>
            </div>

            <!-- English Description -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">English Description</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $product->description_en }}</p>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('superAdmin.products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition">
            {{ __('admin.back_to_products') }}
        </a>
    </div>
</div>

@endsection
