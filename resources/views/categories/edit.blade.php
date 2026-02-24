@extends('admin.layout.app')

@section('page-title', __('admin.edit_category'))

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">{{ __('admin.edit_category') }}</h2>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('category.update', [$salon, $category]) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name Arabic -->
            <div>
                <label for="name_ar" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.category_name_ar') }}</label>
                <input type="text" id="name_ar" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                @error('name_ar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Name English -->
            <div>
                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.category_name_en') }}</label>
                <input type="text" id="name_en" name="name_en" value="{{ old('name_en', $category->name_en) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-gradient-to-r from-[#dd208e] to-[#b01670] hover:shadow-lg text-white font-bold py-2 px-6 rounded-lg transition">
                {{ __('admin.save') }}
            </button>
            <a href="{{ route('category.index', $salon) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition">
                {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
