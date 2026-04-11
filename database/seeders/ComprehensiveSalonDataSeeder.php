<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salon;
use App\Models\Staff;
use App\Models\Service;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use App\Models\Book;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Expense;
use App\Models\SalaryPayment;
use App\Models\StaffSchedule;
use App\Models\StaffLeave;
use App\Models\Coupon;
use App\Models\ServicePackage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ComprehensiveSalonDataSeeder extends Seeder
{
    public function run(): void
    {
        $salon = Salon::first();

        if (!$salon) {
            $this->command->error('No salon found. Please create a salon first.');
            return;
        }

        $this->command->info("Seeding comprehensive data for: {$salon->name_en}");

        // 1. Categories
        $this->seedCategories($salon);

        // 2. More Clients
        $this->seedClients($salon);

        // 3. Products
        $this->seedProducts($salon);

        // 4. Staff Schedules
        $this->seedStaffSchedules($salon);

        // 5. Staff Leave
        $this->seedStaffLeave($salon);

        // 6. Expenses
        $this->seedExpenses($salon);

        // 7. Bookings
        $this->seedBookings($salon);

        // 8. Invoices
        $this->seedInvoices($salon);

        // 9. Salary Payments
        $this->seedSalaryPayments($salon);

        $this->command->info('✅ All data seeded successfully!');
    }

    private function seedCategories(Salon $salon): void
    {
        $categories = [
            ['name_en' => 'Hair Services', 'name_ar' => 'خدمات الشعر'],
            ['name_en' => 'Nail Services', 'name_ar' => 'خدمات الأظافر'],
            ['name_en' => 'Skin Care', 'name_ar' => 'العناية بالبشرة'],
            ['name_en' => 'Makeup', 'name_ar' => 'المكياج'],
            ['name_en' => 'Body Care', 'name_ar' => 'العناية بالجسم'],
            ['name_en' => 'Bridal', 'name_ar' => 'عروس'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['salon_id' => $salon->id, 'name_en' => $cat['name_en']],
                $cat
            );
        }

        $this->command->info('  ✓ Categories seeded');
    }

    private function seedClients(Salon $salon): void
    {
        $clients = [
            ['name_en' => 'Aisha Al-Harthi', 'name_ar' => 'عائشة الحارثي', 'phone' => '96891234567', 'email' => 'aisha@example.com'],
            ['name_en' => 'Maryam Al-Balushi', 'name_ar' => 'مريم البلوشي', 'phone' => '96891234568', 'email' => 'maryam@example.com'],
            ['name_en' => 'Fatima Al-Rashdi', 'name_ar' => 'فاطمة الراشدي', 'phone' => '96891234569', 'email' => 'fatima.r@example.com'],
            ['name_en' => 'Noura Al-Kindi', 'name_ar' => 'نورة الكندي', 'phone' => '96891234570', 'email' => 'noura@example.com'],
            ['name_en' => 'Sara Al-Hinai', 'name_ar' => 'سارة الهنائي', 'phone' => '96891234571', 'email' => 'sara.h@example.com'],
            ['name_en' => 'Huda Al-Farsi', 'name_ar' => 'هدى الفارسي', 'phone' => '96891234572', 'email' => 'huda@example.com'],
            ['name_en' => 'Layla Al-Zadjali', 'name_ar' => 'ليلى الزدجالي', 'phone' => '96891234573', 'email' => 'layla@example.com'],
            ['name_en' => 'Amina Al-Siyabi', 'name_ar' => 'أمينة السيابي', 'phone' => '96891234574', 'email' => 'amina@example.com'],
            ['name_en' => 'Reem Al-Wahaibi', 'name_ar' => 'ريم الوهيبي', 'phone' => '96891234575', 'email' => 'reem@example.com'],
            ['name_en' => 'Dana Al-Amri', 'name_ar' => 'دانة العامري', 'phone' => '96891234576', 'email' => 'dana@example.com'],
            ['name_en' => 'Salma Al-Busaidi', 'name_ar' => 'سلمى البوسعيدي', 'phone' => '96891234577', 'email' => 'salma@example.com'],
            ['name_en' => 'Zainab Al-Lawati', 'name_ar' => 'زينب اللواتي', 'phone' => '96891234578', 'email' => 'zainab@example.com'],
            ['name_en' => 'Khadija Al-Rawahi', 'name_ar' => 'خديجة الرواحي', 'phone' => '96891234579', 'email' => 'khadija@example.com'],
            ['name_en' => 'Marwa Al-Habsi', 'name_ar' => 'مروة الحبسي', 'phone' => '96891234580', 'email' => 'marwa@example.com'],
            ['name_en' => 'Asma Al-Shukaili', 'name_ar' => 'أسماء الشكيلي', 'phone' => '96891234581', 'email' => 'asma@example.com'],
        ];

        foreach ($clients as $i => $client) {
            Client::firstOrCreate(
                ['salon_id' => $salon->id, 'phone' => $client['phone']],
                array_merge($client, [
                    'salon_id' => $salon->id,
                    'client_code' => 'CLT' . str_pad($i + 100, 4, '0', STR_PAD_LEFT),
                    'birthday' => Carbon::now()->subYears(rand(22, 45))->subDays(rand(1, 365))->format('Y-m-d'),
                    'loyalty_points' => rand(0, 500),
                ])
            );
        }

        $this->command->info('  ✓ Clients seeded (' . count($clients) . ' new)');
    }

    private function seedProducts(Salon $salon): void
    {
        $products = [
            ['name_en' => 'Argan Hair Oil', 'name_ar' => 'زيت الأرغان للشعر', 'price' => 15.00, 'cost_price' => 8.00, 'stock' => 25],
            ['name_en' => 'Keratin Shampoo', 'name_ar' => 'شامبو الكيراتين', 'price' => 12.00, 'cost_price' => 6.50, 'stock' => 30],
            ['name_en' => 'Hair Mask Treatment', 'name_ar' => 'قناع علاج الشعر', 'price' => 18.00, 'cost_price' => 9.00, 'stock' => 20],
            ['name_en' => 'Nail Polish Set', 'name_ar' => 'طقم طلاء الأظافر', 'price' => 8.00, 'cost_price' => 3.50, 'stock' => 50],
            ['name_en' => 'Cuticle Oil', 'name_ar' => 'زيت البشرة', 'price' => 5.00, 'cost_price' => 2.00, 'stock' => 40],
            ['name_en' => 'Face Moisturizer', 'name_ar' => 'مرطب الوجه', 'price' => 22.00, 'cost_price' => 12.00, 'stock' => 18],
            ['name_en' => 'Vitamin C Serum', 'name_ar' => 'سيروم فيتامين سي', 'price' => 28.00, 'cost_price' => 15.00, 'stock' => 15],
            ['name_en' => 'Makeup Brush Set', 'name_ar' => 'طقم فرش المكياج', 'price' => 35.00, 'cost_price' => 18.00, 'stock' => 12],
            ['name_en' => 'Setting Spray', 'name_ar' => 'بخاخ تثبيت المكياج', 'price' => 14.00, 'cost_price' => 7.00, 'stock' => 22],
            ['name_en' => 'Lip Gloss Collection', 'name_ar' => 'مجموعة ملمع الشفاه', 'price' => 10.00, 'cost_price' => 4.50, 'stock' => 35],
            ['name_en' => 'Body Lotion', 'name_ar' => 'لوشن الجسم', 'price' => 16.00, 'cost_price' => 8.00, 'stock' => 28],
            ['name_en' => 'Exfoliating Scrub', 'name_ar' => 'مقشر الجسم', 'price' => 19.00, 'cost_price' => 10.00, 'stock' => 16],
        ];

        foreach ($products as $i => $product) {
            Product::firstOrCreate(
                ['salon_id' => $salon->id, 'name_en' => $product['name_en']],
                [
                    'salon_id' => $salon->id,
                    'name_en' => $product['name_en'],
                    'name_ar' => $product['name_ar'],
                    'description_en' => 'Premium quality ' . strtolower($product['name_en']),
                    'description_ar' => 'جودة عالية ' . $product['name_ar'],
                    'price' => $product['price'],
                    'cost_price' => $product['cost_price'],
                    'stock_quantity' => $product['stock'],
                    'min_stock_level' => 5,
                    'sku' => 'PRD' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'image' => 'products/default.jpg',
                ]
            );
        }

        $this->command->info('  ✓ Products seeded (' . count($products) . ')');
    }

    private function seedStaffSchedules(Salon $salon): void
    {
        $staff = Staff::where('salon_id', $salon->id)->get();

        foreach ($staff as $s) {
            // Create schedule for each day (0=Sunday to 6=Saturday)
            for ($day = 0; $day <= 6; $day++) {
                // Friday off for all
                $isDayOff = ($day === 5);

                StaffSchedule::firstOrCreate(
                    ['staff_id' => $s->id, 'salon_id' => $salon->id, 'day_of_week' => $day],
                    [
                        'staff_id' => $s->id,
                        'salon_id' => $salon->id,
                        'day_of_week' => $day,
                        'start_time' => '09:00:00',
                        'end_time' => '18:00:00',
                        'is_day_off' => $isDayOff,
                    ]
                );
            }
        }

        $this->command->info('  ✓ Staff schedules seeded');
    }

    private function seedStaffLeave(Salon $salon): void
    {
        $staff = Staff::where('salon_id', $salon->id)->first();

        if ($staff) {
            // Add some past/future leave
            StaffLeave::firstOrCreate(
                ['staff_id' => $staff->id, 'salon_id' => $salon->id, 'start_date' => Carbon::now()->addDays(10)->format('Y-m-d')],
                [
                    'staff_id' => $staff->id,
                    'salon_id' => $salon->id,
                    'start_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                    'end_date' => Carbon::now()->addDays(12)->format('Y-m-d'),
                    'reason' => 'Personal leave',
                    'status' => 'approved',
                ]
            );
        }

        $this->command->info('  ✓ Staff leave seeded');
    }

    private function seedExpenses(Salon $salon): void
    {
        $expenses = [
            // January
            ['category' => 'rent', 'description' => 'Monthly Rent - January', 'amount' => 500, 'date' => '2026-01-01', 'vat_rate' => 0],
            ['category' => 'utilities', 'description' => 'Electricity Bill - January', 'amount' => 85, 'date' => '2026-01-05', 'vat_rate' => 5],
            ['category' => 'utilities', 'description' => 'Water Bill - January', 'amount' => 25, 'date' => '2026-01-05', 'vat_rate' => 5],
            ['category' => 'supplier', 'description' => 'Hair Products Restock', 'amount' => 350, 'date' => '2026-01-10', 'vat_rate' => 5, 'supplier' => 'Beauty Supplies Co.'],
            ['category' => 'marketing', 'description' => 'Social Media Ads', 'amount' => 150, 'date' => '2026-01-15', 'vat_rate' => 0],

            // February
            ['category' => 'rent', 'description' => 'Monthly Rent - February', 'amount' => 500, 'date' => '2026-02-01', 'vat_rate' => 0],
            ['category' => 'utilities', 'description' => 'Electricity Bill - February', 'amount' => 92, 'date' => '2026-02-05', 'vat_rate' => 5],
            ['category' => 'utilities', 'description' => 'Water Bill - February', 'amount' => 28, 'date' => '2026-02-05', 'vat_rate' => 5],
            ['category' => 'supplier', 'description' => 'Nail Polish & Supplies', 'amount' => 180, 'date' => '2026-02-12', 'vat_rate' => 5, 'supplier' => 'Nail Art Supplies'],
            ['category' => 'maintenance', 'description' => 'AC Maintenance', 'amount' => 75, 'date' => '2026-02-20', 'vat_rate' => 5],
            ['category' => 'equipment', 'description' => 'New Hair Dryers (2)', 'amount' => 120, 'date' => '2026-02-25', 'vat_rate' => 5],

            // March
            ['category' => 'rent', 'description' => 'Monthly Rent - March', 'amount' => 500, 'date' => '2026-03-01', 'vat_rate' => 0],
            ['category' => 'utilities', 'description' => 'Electricity Bill - March', 'amount' => 88, 'date' => '2026-03-05', 'vat_rate' => 5],
            ['category' => 'utilities', 'description' => 'Water Bill - March', 'amount' => 26, 'date' => '2026-03-05', 'vat_rate' => 5],
            ['category' => 'supplier', 'description' => 'Skincare Products', 'amount' => 420, 'date' => '2026-03-08', 'vat_rate' => 5, 'supplier' => 'Derma Supplies'],
            ['category' => 'insurance', 'description' => 'Annual Business Insurance', 'amount' => 600, 'date' => '2026-03-10', 'vat_rate' => 0],
            ['category' => 'marketing', 'description' => 'Ramadan Campaign', 'amount' => 200, 'date' => '2026-03-12', 'vat_rate' => 0],
        ];

        foreach ($expenses as $exp) {
            $vatAmount = $exp['amount'] * ($exp['vat_rate'] / 100);

            Expense::firstOrCreate(
                ['salon_id' => $salon->id, 'description' => $exp['description']],
                [
                    'salon_id' => $salon->id,
                    'category' => $exp['category'],
                    'description' => $exp['description'],
                    'amount' => $exp['amount'],
                    'expense_date' => $exp['date'],
                    'supplier_name' => $exp['supplier'] ?? null,
                    'vat_rate' => $exp['vat_rate'],
                    'vat_amount' => $vatAmount,
                    'is_recurring' => in_array($exp['category'], ['rent', 'utilities']),
                    'recurring_period' => in_array($exp['category'], ['rent', 'utilities']) ? 'monthly' : null,
                ]
            );
        }

        $this->command->info('  ✓ Expenses seeded (' . count($expenses) . ')');
    }

    private function seedBookings(Salon $salon): void
    {
        $clients = Client::where('salon_id', $salon->id)->get();
        $staff = Staff::where('salon_id', $salon->id)->get();
        $services = Service::where('salon_id', $salon->id)->get();

        if ($clients->isEmpty() || $staff->isEmpty() || $services->isEmpty()) {
            $this->command->warn('  ⚠ Skipping bookings - missing clients/staff/services');
            return;
        }

        $statuses = ['scheduled', 'completed', 'canceled'];
        $bookingsData = [];

        // Generate bookings for the past 30 days and next 14 days
        for ($dayOffset = -30; $dayOffset <= 14; $dayOffset++) {
            $date = Carbon::now()->addDays($dayOffset);

            // Skip Fridays
            if ($date->dayOfWeek === 5) continue;

            // 3-8 bookings per day
            $bookingsPerDay = rand(3, 8);

            for ($i = 0; $i < $bookingsPerDay; $i++) {
                $hour = rand(9, 17);
                $minute = [0, 15, 30, 45][rand(0, 3)];

                $client = $clients->random();
                $staffMember = $staff->random();
                $service = $services->random();

                // Status based on date
                if ($dayOffset < -7) {
                    $status = collect(['completed', 'completed', 'completed', 'canceled'])->random();
                } elseif ($dayOffset < 0) {
                    $status = collect(['completed', 'completed', 'canceled'])->random();
                } elseif ($dayOffset === 0) {
                    $status = collect(['scheduled', 'completed', 'scheduled'])->random();
                } else {
                    $status = 'scheduled';
                }

                $bookingsData[] = [
                    'salon_id' => $salon->id,
                    'client_id' => $client->id,
                    'service_id' => $service->id,
                    'staff_id' => $staffMember->id,
                    'appointment_datetime' => $date->copy()->setTime($hour, $minute),
                    'status' => $status,
                    'price' => $service->price,
                    'notes' => rand(0, 1) ? 'Regular client' : null,
                    'whatsapp_reminded' => $dayOffset < 0 ? rand(0, 1) : false,
                ];
            }
        }

        // Insert bookings, skipping duplicates
        $created = 0;
        foreach ($bookingsData as $booking) {
            $exists = Book::where('salon_id', $booking['salon_id'])
                ->where('client_id', $booking['client_id'])
                ->where('appointment_datetime', $booking['appointment_datetime'])
                ->exists();

            if (!$exists) {
                Book::create($booking);
                $created++;
            }
        }

        $this->command->info("  ✓ Bookings seeded ({$created} new)");
    }

    private function seedInvoices(Salon $salon): void
    {
        // Get completed bookings without invoices
        $completedBookings = Book::where('salon_id', $salon->id)
            ->where('status', 'completed')
            ->whereDoesntHave('invoice')
            ->limit(30)
            ->get();

        $products = Product::where('salon_id', $salon->id)->get();
        $paymentMethods = ['cash', 'card', 'wallet'];
        $coupons = Coupon::where('salon_id', $salon->id)->where('is_active', true)->get();

        $created = 0;
        foreach ($completedBookings as $booking) {
            // Generate invoice number
            $invoiceNumber = 'INV-' . $salon->id . '-' . str_pad(Invoice::where('salon_id', $salon->id)->count() + $created + 1, 5, '0', STR_PAD_LEFT);

            $subtotal = $booking->price;
            $discountAmount = 0;
            $couponCode = null;

            // 20% chance to add products
            if ($products->isNotEmpty() && rand(1, 5) === 1) {
                $product = $products->random();
                $subtotal += $product->price;
            }

            // 15% chance to apply coupon
            if ($coupons->isNotEmpty() && rand(1, 7) === 1) {
                $coupon = $coupons->random();
                $couponCode = $coupon->code;
                $discountValue = $coupon->discount_value ?? 0;
                if ($coupon->discount_type === 'percentage') {
                    $discountAmount = $subtotal * ($discountValue / 100);
                } else {
                    $discountAmount = min($discountValue, $subtotal);
                }
            }

            // Ensure discount is a valid number
            $discountAmount = (float) ($discountAmount ?? 0);

            $taxAmount = ($subtotal - $discountAmount) * 0.05; // 5% VAT
            $total = $subtotal - $discountAmount + $taxAmount;

            $invoice = Invoice::create([
                'salon_id' => $salon->id,
                'client_id' => $booking->client_id,
                'booking_id' => $booking->id,
                'invoice_number' => $invoiceNumber,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total' => $total,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'paid_amount' => $total,
                'remaining_amount' => 0,
                'status' => 'paid',
                'coupon_code' => $couponCode,
            ]);

            // Add service as invoice item
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_type' => 'service',
                'item_id' => $booking->service_id,
                'item_name' => $booking->service->name_en ?? 'Service',
                'quantity' => 1,
                'unit_price' => $booking->price,
                'total_price' => $booking->price,
            ]);

            $created++;
        }

        $this->command->info("  ✓ Invoices seeded ({$created} new)");
    }

    private function seedSalaryPayments(Salon $salon): void
    {
        $staff = Staff::where('salon_id', $salon->id)->get();
        $months = ['2026-01', '2026-02'];

        $created = 0;
        foreach ($months as $month) {
            foreach ($staff as $s) {
                $exists = SalaryPayment::where('salon_id', $salon->id)
                    ->where('staff_id', $s->id)
                    ->where('month', $month)
                    ->exists();

                if (!$exists) {
                    $baseSalary = $s->salary ?? 350;

                    // Calculate commission from completed bookings that month
                    $monthStart = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
                    $monthEnd = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

                    $monthRevenue = Book::where('salon_id', $salon->id)
                        ->where('staff_id', $s->id)
                        ->where('status', 'completed')
                        ->whereBetween('appointment_datetime', [$monthStart, $monthEnd])
                        ->sum('price');

                    $commissionRate = $s->commission_rate ?? 10;
                    $commission = $monthRevenue * ($commissionRate / 100);

                    $bonus = rand(0, 1) ? rand(20, 50) : 0;
                    $deductions = rand(0, 1) ? rand(10, 30) : 0;
                    $total = $baseSalary + $commission + $bonus - $deductions;

                    SalaryPayment::create([
                        'salon_id' => $salon->id,
                        'staff_id' => $s->id,
                        'base_salary' => $baseSalary,
                        'commission_amount' => $commission,
                        'bonus' => $bonus,
                        'deductions' => $deductions,
                        'total_amount' => $total,
                        'month' => $month,
                        'status' => 'paid',
                        'paid_date' => Carbon::createFromFormat('Y-m', $month)->endOfMonth()->format('Y-m-d'),
                        'notes' => $bonus > 0 ? 'Performance bonus included' : null,
                    ]);

                    $created++;
                }
            }
        }

        $this->command->info("  ✓ Salary payments seeded ({$created} new)");
    }
}
