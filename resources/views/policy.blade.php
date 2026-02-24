<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('policy.title') }}</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Inter:wght@300..800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                * { font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', 'Inter'" : "'Inter', 'Cairo'" }}, sans-serif; }
            </style>
        @endif
    </head>
    <body class="bg-white text-gray-900" style="font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', 'Inter'" : "'Inter', 'Cairo'" }}, sans-serif;">
        <!-- Navigation Bar -->
        <nav class="fixed top-0 right-0 w-full bg-white shadow-lg z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                   
                   
               
                        <div class="flex gap-3">
                          
                                <a href="{{ route('home') }}" class="px-6 py-2 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white rounded-lg hover:shadow-lg transition text-sm">{{ __('policy.home') }}</a>
                            
                        </div>
                    
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-15 sm:pt-15 pb-12 sm:pb-20">
            <!-- Page Header -->
            <section class="px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-[#fde4f1] to-white py-12 sm:py-20">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 mb-4 sm:mb-6">
                        <span class="bg-gradient-to-r from-[#dd208e] to-[#b01670] bg-clip-text text-transparent">{{ __('policy.title') }}</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-600">
                        {{ __('policy.subtitle') }}
                    </p>
                </div>
            </section>

            <!-- Content Section -->
            <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
                <div class="prose prose-sm sm:prose max-w-none text-gray-700">
                    <!-- 1. نطاق الخدمة -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section1_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                {{ __('policy.section1_intro') }}
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>{{ __('policy.section1_item1') }}</li>
                                <li>{{ __('policy.section1_item2') }}</li>
                                <li>{{ __('policy.section1_item3') }}</li>
                                <li>{{ __('policy.section1_item4') }}</li>
                                <li>{{ __('policy.section1_item5') }}</li>
                                <li>{{ __('policy.section1_item6') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 2. حساب المستخدم -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section2_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                {{ __('policy.section2_intro') }}
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>{{ __('policy.section2_item1') }}</li>
                                <li>{{ __('policy.section2_item2') }}</li>
                                <li>{{ __('policy.section2_item3') }}</li>
                                <li>{{ __('policy.section2_item4') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 3. الاشتراك والدفع -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section3_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                <strong>{{ __('policy.section3_trial_label') }}</strong> {{ __('policy.section3_trial_text') }}
                            </p>
                            <p>
                                <strong>{{ __('policy.section3_fees_label') }}</strong> {{ __('policy.section3_fees_text') }}
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li><strong>{{ __('policy.section3_basic_label') }}</strong> {{ __('policy.section3_basic_price') }}</li>
                                <li><strong>{{ __('policy.section3_advanced_label') }}</strong> {{ __('policy.section3_advanced_price') }}</li>
                                <li><strong>{{ __('policy.section3_premium_label') }}</strong> {{ __('policy.section3_premium_price') }}</li>
                            </ul>
                            <p>
                                <strong>{{ __('policy.section3_payment_label') }}</strong> {{ __('policy.section3_payment_text') }}
                            </p>
                            <p>
                                <strong>{{ __('policy.section3_invoices_label') }}</strong> {{ __('policy.section3_invoices_text') }}
                            </p>
                        </div>
                    </div>

                    <!-- 4. الإلغاء والاسترداد -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section4_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>{{ __('policy.section4_item1') }}</li>
                                <li>{{ __('policy.section4_item2') }}</li>
                                <li>{{ __('policy.section4_item3') }}</li>
                                <li>{{ __('policy.section4_item4') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 5. حماية البيانات والخصوصية -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section5_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                <strong>{{ __('policy.section5_security_label') }}</strong> {{ __('policy.section5_security_text') }}
                            </p>
                            <p>
                                <strong>{{ __('policy.section5_privacy_label') }}</strong> {{ __('policy.section5_privacy_text') }}
                            </p>
                            <p>
                                <strong>{{ __('policy.section5_rights_label') }}</strong> {{ __('policy.section5_rights_text') }}
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>{{ __('policy.section5_item1') }}</li>
                                <li>{{ __('policy.section5_item2') }}</li>
                                <li>{{ __('policy.section5_item3') }}</li>
                                <li>{{ __('policy.section5_item4') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 6. المسؤولية والضمان -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section6_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                <strong>{{ __('policy.section6_warranty_label') }}</strong> {{ __('policy.section6_warranty_text') }}
                            </p>
                            <p>
                                <strong>{{ __('policy.section6_liability_label') }}</strong> {{ __('policy.section6_liability_text') }}
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>{{ __('policy.section6_item1') }}</li>
                                <li>{{ __('policy.section6_item2') }}</li>
                                <li>{{ __('policy.section6_item3') }}</li>
                                <li>{{ __('policy.section6_item4') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 7. استخدام غير مصرح به -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section7_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                {{ __('policy.section7_intro') }}
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>{{ __('policy.section7_item1') }}</li>
                                <li>{{ __('policy.section7_item2') }}</li>
                                <li>{{ __('policy.section7_item3') }}</li>
                                <li>{{ __('policy.section7_item4') }}</li>
                                <li>{{ __('policy.section7_item5') }}</li>
                                <li>{{ __('policy.section7_item6') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 8. الملكية الفكرية -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section8_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                {{ __('policy.section8_text1') }}
                            </p>
                            <p>
                                {{ __('policy.section8_text2') }}
                            </p>
                        </div>
                    </div>

                    <!-- 9. التعديلات والتحديثات -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section9_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                {{ __('policy.section9_text1') }}
                            </p>
                            <p>
                                {{ __('policy.section9_text2') }}
                            </p>
                        </div>
                    </div>

                    <!-- 10. دعم العملاء -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section10_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                {{ __('policy.section10_intro') }}
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li><strong>{{ __('policy.section10_email_label') }}</strong> support@doha.app</li>
                                <li><strong>{{ __('policy.section10_phone_label') }}</strong> 00968-9808-4952</li>
                                <li><strong>{{ __('policy.section10_chat_label') }}</strong> {{ __('policy.section10_chat_text') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 11. القانون الواجب التطبيق -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section11_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                {{ __('policy.section11_text1') }}
                            </p>
                            <p>
                                {{ __('policy.section11_text2') }}
                            </p>
                        </div>
                    </div>

                    <!-- 12. البنود الإضافية -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            {{ __('policy.section12_title') }}
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li><strong>{{ __('policy.section12_integration_label') }}</strong> {{ __('policy.section12_integration_text') }}</li>
                                <li><strong>{{ __('policy.section12_severability_label') }}</strong> {{ __('policy.section12_severability_text') }}</li>
                                <li><strong>{{ __('policy.section12_waiver_label') }}</strong> {{ __('policy.section12_waiver_text') }}</li>
                                <li><strong>{{ __('policy.section12_assignment_label') }}</strong> {{ __('policy.section12_assignment_text') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    <div class="mt-16 p-6 sm:p-8 bg-gradient-to-r from-[#dd208e] to-[#b01670] rounded-xl text-white">
                        <h3 class="text-xl sm:text-2xl font-bold mb-4">{{ __('policy.contact_title') }}</h3>
                        <p class="mb-6 text-red-100">{{ __('policy.contact_subtitle') }}</p>
                        <a href="{{ route('home') }}#contact" class="inline-block px-6 sm:px-8 py-3 sm:py-4 bg-white text-[#dd208e] font-bold rounded-lg hover:shadow-lg transition">
                            {{ __('policy.contact_button') }}
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-white text-gray-900 py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 mb-8">
                    <div class="space-y-3 sm:space-y-4">
                       
                        <img src="{{ asset('images/bg.png') }}" alt="doha logo" class="h-10 sm:h-12 mb-3 sm:mb-4">
                       
                        <p class="text-xs sm:text-sm">{{ __('policy.footer_description') }}</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-base sm:text-lg">{{ __('policy.footer_product') }}</h4>
                        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            <li><a href="{{ route('home') }}#features" class="hover:text-gray-700 transition">{{ __('policy.footer_features') }}</a></li>
                            <li><a href="{{ route('home') }}#pricing" class="hover:text-gray-700 transition">{{ __('policy.footer_pricing') }}</a></li>
                            
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-base sm:text-lg">{{ __('policy.footer_company') }}</h4>
                        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            <li><a href="{{ route('home') }}#about" class="hover:text-gray-700 transition">{{ __('policy.footer_about') }}</a></li>
                            <li><a href="{{ route('blogs.public.index') }}" class="hover:text-gray-700 transition">{{ __('policy.footer_blog') }}</a></li>
                            
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-base sm:text-lg">{{ __('policy.footer_legal') }}</h4>
                        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            
                            <li><a href="{{ route('policy') }}" class="hover:text-gray-700 transition">{{ __('policy.footer_terms') }}</a></li>
                            <li><a href="{{ route('home') }}#contact" class="hover:text-gray-700 transition">{{ __('policy.footer_contact') }}</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-800 pt-6 sm:pt-8 text-center text-xs sm:text-sm">
                    <p>{{ __('policy.footer_copyright') }}</p>
                </div>
            </div>
        </footer> 

        <style>
            * {
                font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', 'Inter'" : "'Inter', 'Cairo'" }}, sans-serif;
            }

            html {
                scroll-behavior: smooth;
            }

            /* Prose styling for better readability */
            .prose h2 {
                scroll-margin-top: 100px;
            }
        </style>
    </body>
</html>
