<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Client;
use App\Models\Product;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@email.com',
            'password' => Hash::make('12345678'),
        ]);

        // Create salon for admin
        $salon = Salon::create([
            'user_id' => $admin->id,
            'name_en' => 'Doha Beauty Salon',
            'name_ar' => 'صالون دوحة للجمال',
            'phone' => '+974 4455 6677',
            'email' => 'info@doha-salon.com',
            'address_en' => 'Doha, Qatar',
            'address_ar' => 'الدوحة، قطر',
            'description_en' => 'Premium beauty and wellness salon',
            'description_ar' => 'صالون متميز للجمال والعناية',
        ]);

        // Create services
        $services = [
            ['name_en' => 'Hair Cutting', 'name_ar' => 'قص الشعر', 'price' => 50, 'duration_minutes' => 30, 'description_en' => 'Professional hair cutting', 'description_ar' => 'قص شعر احترافي'],
            ['name_en' => 'Hair Coloring', 'name_ar' => 'صبغ الشعر', 'price' => 80, 'duration_minutes' => 60, 'description_en' => 'Hair coloring service', 'description_ar' => 'خدمة صبغ الشعر'],
            ['name_en' => 'Manicure', 'name_ar' => 'تصفيف الأظافر', 'price' => 30, 'duration_minutes' => 30, 'description_en' => 'Manicure service', 'description_ar' => 'خدمة تصفيف الأظافر'],
            ['name_en' => 'Pedicure', 'name_ar' => 'باديكير', 'price' => 40, 'duration_minutes' => 45, 'description_en' => 'Pedicure service', 'description_ar' => 'خدمة باديكير'],
            ['name_en' => 'Facial Treatment', 'name_ar' => 'معالجة الوجه', 'price' => 70, 'duration_minutes' => 50, 'description_en' => 'Professional facial', 'description_ar' => 'معالجة وجه احترافية'],
            ['name_en' => 'Threading', 'name_ar' => 'الخيط', 'price' => 20, 'duration_minutes' => 20, 'description_en' => 'Eyebrow threading', 'description_ar' => 'تشقير الحواجب بالخيط'],
        ];

        foreach ($services as $service) {
            Service::create([
                'salon_id' => $salon->id,
                'name_en' => $service['name_en'],
                'name_ar' => $service['name_ar'],
                'price' => $service['price'],
                'duration_minutes' => $service['duration_minutes'],
                'description_en' => $service['description_en'] ?? null,
                'description_ar' => $service['description_ar'] ?? null,
                'is_active' => true,
            ]);
        }

        // Create staff members
        $staffMembers = [
            ['name_en' => 'Fatima Al-Mansouri', 'name_ar' => 'فاطمة المنصوري', 'email' => 'fatima@doha-salon.com', 'phone' => '+974 3366 5544', 'position_en' => 'Senior Stylist', 'position_ar' => 'أخصائية تصفيف أول'],
            ['name_en' => 'Layla Ahmed', 'name_ar' => 'ليلى أحمد', 'email' => 'layla@doha-salon.com', 'phone' => '+974 3366 5545', 'position_en' => 'Hair Specialist', 'position_ar' => 'أخصائية شعر'],
            ['name_en' => 'Noor Hassan', 'name_ar' => 'نور حسن', 'email' => 'noor@doha-salon.com', 'phone' => '+974 3366 5546', 'position_en' => 'Beauty Therapist', 'position_ar' => 'معالجة جمال'],
            ['name_en' => 'Sara Mohammad', 'name_ar' => 'سارة محمد', 'email' => 'sara@doha-salon.com', 'phone' => '+974 3366 5547', 'position_en' => 'Nail Technician', 'position_ar' => 'فنية أظافر'],
            ['name_en' => 'Huda Ali', 'name_ar' => 'هدى علي', 'email' => 'huda@doha-salon.com', 'phone' => '+974 3366 5548', 'position_en' => 'Esthetician', 'position_ar' => 'خبيرة تجميل'],
        ];

        $createdStaff = [];
        foreach ($staffMembers as $staff) {
            $createdStaff[] = Staff::create([
                'salon_id' => $salon->id,
                'name_en' => $staff['name_en'],
                'name_ar' => $staff['name_ar'],
                'email' => $staff['email'],
                'phone' => $staff['phone'],
                'position_en' => $staff['position_en'],
                'position_ar' => $staff['position_ar'],
            ]);
        }

        // Assign services to staff
        $allServices = Service::where('salon_id', $salon->id)->get();
        foreach ($createdStaff as $staff) {
            $staff->services()->attach($allServices->random(3)->pluck('id')->toArray());
        }

        // Create clients
        $clients = [
            ['name_en' => 'Amira Mohammed', 'name_ar' => 'أميرة محمد', 'phone' => '+974 5511 2233', 'email' => 'amira@example.com'],
            ['name_en' => 'Zahra Ibrahim', 'name_ar' => 'زهرة إبراهيم', 'phone' => '+974 5522 3344', 'email' => 'zahra@example.com'],
            ['name_en' => 'Leena Hassan', 'name_ar' => 'لينا حسن', 'phone' => '+974 5533 4455', 'email' => 'leena@example.com'],
            ['name_en' => 'Mona Ali', 'name_ar' => 'منى علي', 'phone' => '+974 5544 5566', 'email' => 'mona@example.com'],
            ['name_en' => 'Rania Khalid', 'name_ar' => 'رانيا خالد', 'phone' => '+974 5555 6677', 'email' => 'rania@example.com'],
        ];

        $createdClients = [];
        foreach ($clients as $client) {
            $createdClients[] = Client::create([
                'salon_id' => $salon->id,
                'name_en' => $client['name_en'],
                'name_ar' => $client['name_ar'],
                'phone' => $client['phone'],
                'email' => $client['email'],
                'client_code' => strtoupper(substr($client['name_en'], 0, 3)) . rand(1000, 9999),
            ]);
        }

        // Create products
        $products = [
            ['name_en' => 'Shampoo Pro', 'name_ar' => 'شامبو برو', 'price' => 25, 'stock_quantity' => 50],
            ['name_en' => 'Hair Conditioner', 'name_ar' => 'بلسم الشعر', 'price' => 30, 'stock_quantity' => 40],
            ['name_en' => 'Face Mask', 'name_ar' => 'قناع الوجه', 'price' => 35, 'stock_quantity' => 35],
            ['name_en' => 'Hair Oil', 'name_ar' => 'زيت الشعر', 'price' => 20, 'stock_quantity' => 60],
            ['name_en' => 'Nail Polish Set', 'name_ar' => 'مجموعة طلاء الأظافر', 'price' => 15, 'stock_quantity' => 100],
        ];

        foreach ($products as $product) {
            Product::create([
                'salon_id' => $salon->id,
                'name_en' => $product['name_en'],
                'name_ar' => $product['name_ar'],
                'price' => $product['price'],
                'stock_quantity' => $product['stock_quantity'],
                'description_en' => 'Premium quality product',
                'description_ar' => 'منتج عالي الجودة',
                'image' => 'products/default.jpg',
            ]);
        }

        // Create bookings
        $bookingStatuses = ['scheduled', 'completed', 'canceled'];
        for ($i = 0; $i < 15; $i++) {
            Book::create([
                'salon_id' => $salon->id,
                'client_id' => $createdClients[array_rand($createdClients)]->id,
                'service_id' => $allServices[array_rand($allServices->toArray())]->id,
                'staff_id' => $createdStaff[array_rand($createdStaff)]->id,
                'appointment_datetime' => now()->addDays(rand(-7, 30))->setTime(rand(9, 17), 0),
                'status' => $bookingStatuses[array_rand($bookingStatuses)],
                'price' => rand(20, 100),
                'notes' => 'Client appointment',
            ]);
        }
    }
}
