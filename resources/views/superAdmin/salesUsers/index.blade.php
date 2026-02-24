@extends('superAdmin.layout.app')

@section('page-title', __('admin.sales_users'))

@section('content')

<div class="flex justify-between items-center mb-6 flex-wrap gap-4">
    <div>
        <p class="text-gray-500 text-sm mt-1">{{ __('admin.total') }}: {{ $salesUsers->count() }}</p>
    </div>
    <a href="{{ route('superAdmin.salesUsers.create') }}" class="bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold transition shadow-lg shadow-pink-200 flex items-center gap-2">
        <i class="fas fa-plus"></i> {{ __('admin.add_sales_user') }}
    </a>
</div>

@if(session('success'))
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/80">
                    <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('admin.name') }}</th>
                    <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('admin.email') }}</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('admin.phone') }}</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('admin.commission') }} %</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('admin.salons') }}</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('admin.total_commission') }}</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('admin.action') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($salesUsers as $user)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                {{ mb_substr($user->name, 0, 1) }}
                            </div>
                            <span class="font-semibold text-gray-900 text-sm">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600" dir="ltr">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 text-center" dir="ltr">{{ $user->phone ?? '—' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-block bg-pink-50 text-pink-700 px-3 py-1 rounded-full text-xs font-bold">
                            {{ $user->commission_rate }}%
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                            {{ $user->sold_salons_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-sm text-green-600">
                        {{ number_format($user->totalCommissionEarned(), 2) }} {{ __('admin.omr') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('superAdmin.salesUsers.edit', $user) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="{{ __('admin.edit') }}">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('superAdmin.salesUsers.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="{{ __('admin.delete') }}">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-users-slash text-3xl mb-3 block"></i>
                        <p>{{ __('admin.no_sales_users') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
