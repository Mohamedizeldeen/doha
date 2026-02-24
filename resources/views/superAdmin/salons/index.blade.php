@extends('superAdmin.layout.app')

@section('page-title', __('admin.salons'))

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">{{ __('admin.manage_salons') }}</h1>
    <a href="{{ route('superAdmin.salons.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition">
        + {{ __('admin.add_salon') }}
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.salon_name') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.owner') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.sales_person') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.phone') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.services') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.staff') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.products') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.bookings') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.revenue') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.account_status') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salons as $salon)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ app()->getLocale() === 'ar' ? $salon->name_ar : ($salon->name_en ?? $salon->name_ar) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $salon->user->name ?? __('admin.not_specified') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            @if($salon->salesUser)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold" style="background: rgba(221,32,142,0.1); color: #dd208e;">
                                    <i class="fas fa-user-tie"></i>
                                    {{ $salon->salesUser->name }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 ltr">{{ $salon->phone }}</td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $salon->services_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $salon->staff_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="inline-block bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $salon->products_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <span class="inline-block bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $salon->bookings_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center font-semibold text-gray-900">
                            {{ number_format($salon->revenue, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            @if($salon->user && $salon->user->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <i class="fas fa-check-circle"></i> {{ __('admin.active') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fas fa-ban"></i> {{ __('admin.blocked') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center items-center gap-3 flex-row-reverse">
                                <a href="{{ route('superAdmin.salons.show', $salon->id) }}"
                                   aria-label="{{ __('admin.view') }}"
                                   class="inline-flex items-center justify-center bg-white border border-blue-500 text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
                                    {{ __('admin.view') }}
                                </a>

                                <a href="{{ route('superAdmin.salons.edit', $salon->id) }}"
                                   aria-label="{{ __('admin.edit_salon') }}"
                                   class="inline-flex items-center justify-center bg-white border border-yellow-500 text-yellow-600 hover:bg-yellow-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                    {{ __('admin.edit') }}
                                </a>

                                <form action="{{ route('superAdmin.salons.toggleStatus', $salon->id) }}" method="POST" class="inline">
                                    @csrf
                                    @if($salon->user && $salon->user->is_active)
                                        <button type="submit"
                                                onclick="return confirm('{{ __('admin.confirm_block_salon') }}')"
                                                class="inline-flex items-center justify-center bg-orange-600 text-white hover:bg-orange-700 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-orange-300">
                                            <i class="fas fa-ban me-1"></i> {{ __('admin.block') }}
                                        </button>
                                    @else
                                        <button type="submit"
                                                class="inline-flex items-center justify-center bg-green-600 text-white hover:bg-green-700 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-green-300">
                                            <i class="fas fa-check-circle me-1"></i> {{ __('admin.unblock') }}
                                        </button>
                                    @endif
                                </form>

                                <form action="{{ route('superAdmin.salons.destroy', $salon->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('{{ __('admin.confirm_delete_salon') }}');">
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
                        <td colspan="11" class="px-6 py-8 text-center text-gray-500">{{ __('admin.no_salons_system') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $salons->links() }}
</div>

@endsection
