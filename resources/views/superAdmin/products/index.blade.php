@extends('superAdmin.layout.app')

@section('page-title', __('admin.products'))

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">{{ __('admin.manage_products') }}</h1>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.product_name') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.salon') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.price') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.stock') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.description') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.created_at') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ app()->getLocale() === 'ar' ? $product->name_ar : ($product->name_en ?? $product->name_ar) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <a href="{{ route('superAdmin.salons.show', $product->salon->id) }}" class="text-blue-600 hover:text-blue-700">
                                {{ app()->getLocale() === 'ar' ? $product->salon->name_ar : ($product->salon->name_en ?? $product->salon->name_ar) }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            {{ $product->price }} {{ $product->salon->currency }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                @if($product->stock_quantity > 0) bg-green-100 text-green-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-xs">
                            {{ Str::limit(app()->getLocale() === 'ar' ? $product->description_ar : ($product->description_en ?? $product->description_ar), 50) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 text-center">
                            {{ $product->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center items-center gap-3 flex-row-reverse">
                                <a href="{{ route('superAdmin.products.show', $product->id) }}"
                                   aria-label="{{ __('admin.view') }}"
                                   class="inline-flex items-center justify-center bg-white border border-blue-500 text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
                                    {{ __('admin.view') }}
                                </a>

                                <a href="{{ route('superAdmin.products.edit', $product->id) }}"
                                   aria-label="{{ __('admin.edit_product') }}"
                                   class="inline-flex items-center justify-center bg-white border border-yellow-500 text-yellow-600 hover:bg-yellow-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                    {{ __('admin.edit') }}
                                </a>

                                <form action="{{ route('superAdmin.products.destroy', $product->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('{{ __('admin.confirm_delete_product') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            aria-label="{{ __('admin.delete') }}"
                                            class="inline-flex items-center justify-center bg-red-600 text-white hover:bg-red-700 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-red-300">
                                        {{ __('admin.delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">{{ __('admin.no_products_system') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $products->links() }}
</div>

@endsection
