<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $blog->name }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                * { font-family: 'Cairo', sans-serif; }
            </style>
        @endif
    </head>
    <body class="bg-white text-gray-900" style="font-family: 'Cairo', sans-serif;">
        <!-- Navigation Bar -->
          <nav class="fixed top-0 right-0 w-full bg-white shadow-lg z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition">
                        <img src="{{ asset('images/bg.png') }}" alt="Logo" class="h-8 w-auto">
                    </a>
                   
               
                        <div class="flex gap-3">
                          
                                <a href="{{ route('home') }}" class="px-6 py-2 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white rounded-lg hover:shadow-lg transition text-sm">الصفحة الرئيسية</a>
                            
                        </div>
                    
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-15 sm:pt-15">
            <!-- Blog Header -->
            <section class="px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-[#fde4f1] to-white py-12 sm:py-16">
                <div class="max-w-4xl mx-auto">
                    <a href="{{ route('blogs.public.index') }}" class="inline-flex items-center text-[#dd208e] hover:text-[#b01670] font-medium mb-6 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        العودة إلى المدونة
                    </a>

                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 mb-4 sm:mb-6 leading-tight">
                        {{ $blog->name }}
                    </h1>

                    <div class="flex flex-wrap gap-4 items-center text-sm text-gray-600 mb-8">
                        @if($blog->category)
                            <span class="inline-block bg-[#dd208e] bg-opacity-10 text-[#dd208e] px-4 py-2 rounded-full font-semibold text-white">
                                {{ $blog->category }}
                            </span>
                        @endif
                        <span>{{ $blog->created_at->format('d F Y') }}</span>
                        <span>•</span>
                        <span>آخر تحديث: {{ $blog->updated_at->format('d F Y H:i') }}</span>
                    </div>
                </div>
            </section>

            <!-- Featured Image -->
            @if($blog->image)
                <section class="px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                    <div class="max-w-4xl mx-auto">
                        <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->name }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
                    </div>
                </section>
            @endif

            <!-- Blog Content -->
            <article class="px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                <div class="max-w-4xl mx-auto">
                    <!-- Short Description -->
                    <div class="bg-gradient-to-r from-[#fde4f1] to-[#fff5f9] rounded-lg p-6 sm:p-8 mb-10 border border-[#f0b3d8]">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-3">الملخص</h2>
                        <p class="text-gray-700 leading-relaxed text-base">
                            {{ $blog->short_description }}
                        </p>
                    </div>

                    <!-- Main Content -->
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-4">
                        @php
                            // تنظيف المحتوى من الفراغات الزائدة
                            $content = trim($blog->content);
                            // تحويل أسطر جديدة متعددة إلى فاصل فقرة واحد
                            $content = preg_replace('/\n\n+/', '</p><p>', $content);
                            $content = '<p>' . $content . '</p>';
                            // تحويل الأسطر الفردية إلى فواصل سطور عادية
                            $content = nl2br($content);
                        @endphp
                        {!! $content !!}
                    </div>

                    <!-- Related Section -->
                    <div class="mt-16 pt-8 border-t-2 border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">المزيد من المقالات</h3>
                        @php
                            $relatedBlogs = App\Models\Blog::where('id', '!=', $blog->id)
                                ->when($blog->category, function($q) use ($blog) {
                                    return $q->where('category', $blog->category);
                                })
                                ->limit(3)
                                ->get();
                        @endphp

                        @if($relatedBlogs->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($relatedBlogs as $relatedBlog)
                                    <a href="{{ route('blogs.public.show', $relatedBlog->id) }}" class="group bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden border border-gray-100">
                                        <div class="relative overflow-hidden bg-gray-200 h-40">
                                            @if($relatedBlog->image)
                                                <img src="{{ Storage::url($relatedBlog->image) }}" alt="{{ $relatedBlog->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#dd208e] to-[#b01670]">
                                                    <span class="text-white text-3xl">📝</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="p-4">
                                            <h4 class="font-bold text-gray-900 mb-2 group-hover:text-[#dd208e] transition line-clamp-2">
                                                {{ $relatedBlog->name }}
                                            </h4>
                                            
                                            <p class="text-xs text-gray-500 mb-3">
                                                {{ $relatedBlog->created_at->format('d/m/Y') }}
                                            </p>
                                            
                                            <span class="text-[#dd208e] font-medium text-sm">اقرأ المزيد ←</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">لا توجد مقالات مرتبطة</p>
                        @endif
                    </div>

                    <!-- CTA Section -->
                    <div class="mt-16 p-8 sm:p-12 bg-gradient-to-r from-[#dd208e] to-[#b01670] rounded-lg text-white text-center">
                        <h3 class="text-2xl sm:text-3xl font-bold mb-4">هل أنت مهتم بتحسين إدارة صالونك؟</h3>
                        <p class="text-lg text-red-100 mb-6">ابدأ رحلتك معنا اليوم واستمتع بـ 14 يوم تجريبي مجاني</p>
                        <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-white text-[#dd208e] font-bold rounded-lg hover:shadow-lg transition">
                            التسجيل المجاني
                        </a>
                    </div>
                </div>
            </article>
        </main>

               <!-- Footer -->
        <footer class="bg-white text-gray-900 py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 mb-8">
                    <div class="space-y-3 sm:space-y-4">
                       
                        <img src="{{ asset('images/bg.png') }}" alt="doha logo" class="h-10 sm:h-12 mb-3 sm:mb-4">
                       
                        <p class="text-xs sm:text-sm">حل متكامل لإدارة صالونات ومراكز التجميل</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-base sm:text-lg">المنتج</h4>
                        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            <li><a href="{{ route('home') }}#features" class="hover:text-gray-700 transition">المميزات</a></li>
                            <li><a href="{{ route('home') }}#pricing" class="hover:text-gray-700 transition">الأسعار</a></li>
                            
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-base sm:text-lg">الشركة</h4>
                        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            <li><a href="{{ route('home') }}#about" class="hover:text-gray-700 transition">عننا</a></li>
                            <li><a href="{{ route('blogs.public.index') }}" class="hover:text-gray-700 transition">المدونة</a></li>
                            
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-base sm:text-lg">قانوني</h4>
                        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            
                            <li><a href="{{ route('policy') }}" class="hover:text-gray-700 transition">الشروط و الاحكام</a></li>
                            <li><a href="{{ route('home') }}#contact" class="hover:text-gray-700 transition">التواصل</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-800 pt-6 sm:pt-8 text-center text-xs sm:text-sm">
                    <p>&copy; 2026 . جميع الحقوق محفوظة.</p>
                    <a href="https://www.instagram.com/mohamed_izeldeen/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 text-[#dd208e] hover:text-[#b01670] mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M7 2C4.23858 2 2 4.23858 2 7v10c0 2.7614 2.23858 5 5 5h10c2.7614 0 5-2.2386 5-5V7c0-2.76142-2.2386-5-5-5H7zm10 2c1.657 0 3 1.343 3 3v10c0 1.657-1.343 3-3 3H7c-1.657 0-3-1.343-3-3V7c0-1.657 1.343-3 3-3h10zM12 7.75a4.25 4.25 0 100 8.5 4.25 4.25 0 000-8.5zm0 2a2.25 2.25 0 110 4.5 2.25 2.25 0 010-4.5zM17.5 6.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                        </svg>
                        <span>تم التطوير بواسطة محمد عزالدين</span>
                    </a>
                </div>
            </div>
        </footer> 

        <style>
            html {
                scroll-behavior: smooth;
            }
        </style>
    </body>
</html>
