@extends('superAdmin.layout.app')

@section('page-title', __('admin.messages'))

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">{{ __('admin.manage_messages') }}</h1>
</div>

<!-- Search and Filter Form -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.search_by_name_or_email') }}</label>
            <input type="text" name="search" placeholder="{{ __('admin.search_placeholder') }}" value="{{ request('search') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                {{ __('admin.search') }}
            </button>
            <a href="{{ route('superAdmin.contacts.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition text-center">
                {{ __('admin.clear') }}
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.name') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.email') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.subject') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.phone') }}</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">{{ __('admin.date') }}</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">{{ __('admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $contact->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $contact->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $contact->title ?? __('admin.no_subject') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $contact->phone ?? __('admin.not_available') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center items-center gap-3 flex-row-reverse">
                                <a href="{{ route('superAdmin.contacts.show', $contact->id) }}"
                                   aria-label="{{ __('admin.view_message') }}"
                                   class="inline-flex items-center justify-center bg-white border border-blue-500 text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-300">
                                    {{ __('admin.view') }}
                                </a>

                                <form action="{{ route('superAdmin.contacts.destroy', $contact->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ __('admin.confirm_delete_message') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            aria-label="{{ __('admin.delete_message') }}"
                                            class="inline-flex items-center justify-center bg-white border border-red-500 text-red-600 hover:bg-red-50 px-3 py-2 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-red-300">
                                        {{ __('admin.delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <p class="text-lg">{{ __('admin.no_messages') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($contacts->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <div dir="ltr">
                {{ $contacts->links() }}
            </div>
        </div>
    @endif
</div>

@endsection
