<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>الشروط والأحكام </title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
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
        <main class="pt-15 sm:pt-15 pb-12 sm:pb-20">
            <!-- Page Header -->
            <section class="px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-[#fde4f1] to-white py-12 sm:py-20">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 mb-4 sm:mb-6">
                        <span class="bg-gradient-to-r from-[#dd208e] to-[#b01670] bg-clip-text text-transparent">الشروط والأحكام</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-600">
                        يرجى قراءة الشروط والأحكام التالية بعناية قبل استخدام المنصة 
                    </p>
                </div>
            </section>

            <!-- Content Section -->
            <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
                <div class="prose prose-sm sm:prose max-w-none text-gray-700">
                    <!-- 1. نطاق الخدمة -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            1. نطاق الخدمة
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                المنصة توفر حلاً متكاملاً لإدارة الصالونات والعيادات ومراكز التجميل. تشمل الخدمات:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>نظام إدارة الحجوزات والمواعيد</li>
                                <li>إدارة الخدمات والأسعار</li>
                                <li>إدارة الموارد البشرية والموظفين</li>
                                <li>نظام تتبع المدفوعات والفواتير</li>
                                <li>التقارير والإحصائيات المتقدمة</li>
                                <li>تطبيق جوال للعملاء</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 2. حساب المستخدم -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            2. حساب المستخدم والمسؤولية
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                أنت توافق على أن تكون مسؤولاً عن:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>الحفاظ على سرية بيانات حسابك وكلمة المرور</li>
                                <li>جميع الأنشطة التي تحدث تحت حسابك</li>
                                <li>تحديث المعلومات الشخصية والتجارية بشكل دوري</li>
                                <li>الامتثال لجميع القوانين والأنظمة المعمول بها</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 3. الاشتراك والدفع -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            3. الاشتراك والدفع
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                <strong>الفترة التجريبية:</strong> نوفر فترة تجريبية مجانية مدتها 14 يوماً بدون الحاجة لبطاقة ائتمان.
                            </p>
                            <p>
                                <strong>الرسوم:</strong> بعد انتهاء الفترة التجريبية، ستُفرض رسوم الاشتراك وفقاً للخطة المختارة:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li><strong>الخطة الأساسية:</strong> $15 شهرياً</li>
                                <li><strong>الخطة المتقدمة:</strong> $45 شهرياً</li>
                                <li><strong>الخطة المتميزة:</strong> $120 سنوياً (توفير 33%)</li>
                            </ul>
                            <p>
                                <strong>طريقة الدفع:</strong> يتم الدفع بشكل آمن عبر بوابات الدفع المرخصة.
                            </p>
                            <p>
                                <strong>الفواتير:</strong> ستتلقى فواتير الاشتراك عبر بريدك الإلكتروني.
                            </p>
                        </div>
                    </div>

                    <!-- 4. الإلغاء والاسترداد -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            4. الإلغاء والاسترداد
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>يمكنك إلغاء الاشتراك في أي وقت بدون عقوبات</li>
                                <li>سيتم إيقاف الرسوم عند إلغاء الاشتراك</li>
                                <li>لا يتم استرجاع الرسوم المدفوعة مسبقاً</li>
                                <li>بيانات حسابك ستُحفظ لمدة 30 يوماً قبل الحذف النهائي</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 5. حماية البيانات والخصوصية -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            5. حماية البيانات والخصوصية
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                <strong>الأمان:</strong> نستخدم تقنيات التشفير العالية لحماية بيانات حسابك.
                            </p>
                            <p>
                                <strong>الخصوصية:</strong> نلتزم بسياسات الخصوصية الدولية ولا نشارك بياناتك مع أطراف ثالثة دون موافقتك.
                            </p>
                            <p>
                                <strong>حقوق العميل:</strong> لديك الحق في:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>الوصول إلى بيانات حسابك</li>
                                <li>تعديل معلوماتك الشخصية</li>
                                <li>حذف حسابك والبيانات المرتبطة به</li>
                                <li>نقل بيانات حسابك إلى منصة أخرى</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 6. المسؤولية والضمان -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            6. المسؤولية والضمان
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                <strong>الضمان الضمني:</strong> نضمن توفر الخدمة بنسبة 99.5% مع استثناءات الصيانة المخطط لها.
                            </p>
                            <p>
                                <strong>تحديد المسؤولية:</strong> لن نكون مسؤولين عن:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>الأضرار العرضية أو غير المباشرة</li>
                                <li>فقدان البيانات نتيجة إهمال المستخدم</li>
                                <li>الأخطاء التقنية غير المتوقعة</li>
                                <li>انقطاع الخدمة بسبب قوة قاهرة</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 7. استخدام غير مصرح به -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            7. الاستخدام المحظور
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                أنت توافق على عدم استخدام المنصة في:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>انتهاك القوانين والأنظمة</li>
                                <li>استخدام غير قانوني أو تجاري غير مصرح</li>
                                <li>إساءة معاملة أو تحرش بموظفي الدعم</li>
                                <li>محاولات اختراق أو القرصنة</li>
                                <li>نشر محتوى يسيء أو مسيء</li>
                                <li>انتهاك حقوق الآخرين الفكرية</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 8. الملكية الفكرية -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            8. الملكية الفكرية
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                جميع محتويات المنصة وتصميمها وخوارزمياتها محمية بحقوق الملكية الفكرية. لا يسمح بنسخ أو تعديل أو توزيع أي جزء من المنصة بدون إذن صريح.
                            </p>
                            <p>
                                بيانات حسابك وبيانات العملاء تبقى ملكك بالكامل.
                            </p>
                        </div>
                    </div>

                    <!-- 9. التعديلات والتحديثات -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            9. التعديلات والتحديثات
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                نحتفظ بحق تعديل هذه الشروط في أي وقت. سيتم إخطارك بأي تغييرات جوهرية عبر البريد الإلكتروني.
                            </p>
                            <p>
                                استمرارك في استخدام المنصة بعد التعديلات يعني موافقتك على الشروط الجديدة.
                            </p>
                        </div>
                    </div>

                    <!-- 10. دعم العملاء -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            10. دعم العملاء والتواصل
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                نقدم دعماً على مدار الساعة طوال أيام الأسبوع. يمكنك التواصل معنا:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li><strong>البريد الإلكتروني:</strong> support@doha.app</li>
                                <li><strong>الهاتف:</strong> 00968-9808-4952</li>
                                <li><strong>دردشة مباشرة:</strong> متاحة في المنصة</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 11. القانون الواجب التطبيق -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            11. القانون الواجب التطبيق
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <p>
                                تخضع هذه الشروط وأي نزاعات ناشئة عنها لقوانين سلطنة عمان.
                            </p>
                            <p>
                                تتنازل أنت عن حقك في محاكمة أمام هيئة محلفين والحق في الاستئناف.
                            </p>
                        </div>
                    </div>

                    <!-- 12. البنود الإضافية -->
                    <div class="mb-10 sm:mb-14">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-[#dd208e]">
                            12. أحكام متفرقة
                        </h2>
                        <div class="space-y-4 text-sm sm:text-base leading-relaxed">
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li><strong>التكامل:</strong> هذه الشروط تمثل الاتفاق الكامل بيننا</li>
                                <li><strong>القابلية للفصل:</strong> إذا كان أي بند غير صحيح قانونياً، فستبقى البنود الأخرى سارية</li>
                                <li><strong>عدم التنازل:</strong> عدم فرضنا لأي حق لا يعني التخلي عنه</li>
                                <li><strong>الإسناد:</strong> لا يمكنك نقل حقوقك أو التزاماتك إلى طرف ثالث</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    <div class="mt-16 p-6 sm:p-8 bg-gradient-to-r from-[#dd208e] to-[#b01670] rounded-xl text-white">
                        <h3 class="text-xl sm:text-2xl font-bold mb-4">لديك أسئلة حول الشروط؟</h3>
                        <p class="mb-6 text-red-100">نحن هنا للمساعدة. تواصل معنا في أي وقت</p>
                        <a href="{{ route('home') }}#contact" class="inline-block px-6 sm:px-8 py-3 sm:py-4 bg-white text-[#dd208e] font-bold rounded-lg hover:shadow-lg transition">
                            تواصل معنا
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
                </div>
            </div>
        </footer> 

        <style>
            * {
                font-family: 'Cairo', sans-serif;
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
