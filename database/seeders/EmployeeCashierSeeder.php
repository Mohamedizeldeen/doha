<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Salon;
use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeCashierSeeder extends Seeder
{
    public function run(): void
    {
        $salon = Salon::first();
        if (!$salon) {
            $this->command->error('No salon found. Please create a salon first.');
            return;
        }

        // ── Employee Accounts ────────────────────────────────
        $staff1 = DB::table('staff')->where('salon_id', $salon->id)->first();
        $staff2 = DB::table('staff')->where('salon_id', $salon->id)->skip(1)->first();

        if ($staff1) {
            User::firstOrCreate(
                ['email' => 'employee1@nld.com'],
                [
                    'name' => $staff1->name_en,
                    'email' => 'employee1@nld.com',
                    'phone' => '0501001001',
                    'password' => Hash::make('12345678'),
                    'role' => 'employee',
                    'salon_id' => $salon->id,
                    'staff_id' => $staff1->id,
                    'is_active' => true,
                ]
            );
            $this->command->info("Employee account created: employee1@nld.com (linked to {$staff1->name_en})");
        }

        if ($staff2) {
            User::firstOrCreate(
                ['email' => 'employee2@nld.com'],
                [
                    'name' => $staff2->name_en,
                    'email' => 'employee2@nld.com',
                    'phone' => '0501001002',
                    'password' => Hash::make('12345678'),
                    'role' => 'employee',
                    'salon_id' => $salon->id,
                    'staff_id' => $staff2->id,
                    'is_active' => true,
                ]
            );
            $this->command->info("Employee account created: employee2@nld.com (linked to {$staff2->name_en})");
        }

        // ── Cashier Account ─────────────────────────────────
        User::firstOrCreate(
            ['email' => 'cashier@nld.com'],
            [
                'name' => 'Cashier',
                'email' => 'cashier@nld.com',
                'phone' => '0501002001',
                'password' => Hash::make('12345678'),
                'role' => 'cashier',
                'salon_id' => $salon->id,
                'staff_id' => null,
                'is_active' => true,
            ]
        );
        $this->command->info("Cashier account created: cashier@nld.com");

        // ── Packages ────────────────────────────────────────
        $services = DB::table('services')->where('salon_id', $salon->id)->get();
        if ($services->count() >= 3) {
            // Package 1: Beauty Essentials
            $pkg1 = DB::table('service_packages')->insertGetId([
                'salon_id' => $salon->id,
                'name_en' => 'Beauty Essentials',
                'name_ar' => 'أساسيات التجميل',
                'description_en' => 'Hair cutting + Manicure + Pedicure at a special price',
                'description_ar' => 'قص شعر + مانيكير + باديكير بسعر خاص',
                'original_price' => 120.00,
                'package_price' => 95.00,
                'is_active' => true,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonths(3)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Link services (Hair Cutting=1, Manicure=3, Pedicure=4)
            foreach ([1, 3, 4] as $sId) {
                if ($services->where('id', $sId)->count()) {
                    DB::table('package_service')->insert([
                        'service_package_id' => $pkg1,
                        'service_id' => $sId,
                        'quantity' => 1,
                    ]);
                }
            }
            $this->command->info("Package created: Beauty Essentials (95 OMR)");

            // Package 2: Premium Pampering
            $pkg2 = DB::table('service_packages')->insertGetId([
                'salon_id' => $salon->id,
                'name_en' => 'Premium Pampering',
                'name_ar' => 'العناية المميزة',
                'description_en' => 'Full pampering session: Hair Coloring + Facial Treatment + Manicure + Pedicure',
                'description_ar' => 'جلسة عناية كاملة: صبغة شعر + تنظيف بشرة + مانيكير + باديكير',
                'original_price' => 220.00,
                'package_price' => 175.00,
                'is_active' => true,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonths(6)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            foreach ([2, 3, 4, 5] as $sId) {
                if ($services->where('id', $sId)->count()) {
                    DB::table('package_service')->insert([
                        'service_package_id' => $pkg2,
                        'service_id' => $sId,
                        'quantity' => 1,
                    ]);
                }
            }
            $this->command->info("Package created: Premium Pampering (175 OMR)");

            // Package 3: Quick Refresh
            $pkg3 = DB::table('service_packages')->insertGetId([
                'salon_id' => $salon->id,
                'name_en' => 'Quick Refresh',
                'name_ar' => 'تجديد سريع',
                'description_en' => 'Threading + Manicure — perfect quick refresh',
                'description_ar' => 'خيط + مانيكير — تجديد سريع مثالي',
                'original_price' => 50.00,
                'package_price' => 40.00,
                'is_active' => true,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonths(2)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            foreach ([3, 6] as $sId) {
                if ($services->where('id', $sId)->count()) {
                    DB::table('package_service')->insert([
                        'service_package_id' => $pkg3,
                        'service_id' => $sId,
                        'quantity' => 1,
                    ]);
                }
            }
            $this->command->info("Package created: Quick Refresh (40 OMR)");
        }

        // ── Coupons ─────────────────────────────────────────
        Coupon::firstOrCreate(
            ['code' => 'WELCOME10'],
            [
                'salon_id' => $salon->id,
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10.00,
                'min_order_amount' => 20.00,
                'max_uses' => 100,
                'used_count' => 0,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonths(6)->toDateString(),
                'is_active' => true,
            ]
        );
        $this->command->info("Coupon created: WELCOME10 (10% off, min 20 OMR)");

        Coupon::firstOrCreate(
            ['code' => 'SAVE5'],
            [
                'salon_id' => $salon->id,
                'code' => 'SAVE5',
                'type' => 'fixed',
                'value' => 5.00,
                'min_order_amount' => 30.00,
                'max_uses' => 50,
                'used_count' => 0,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonths(3)->toDateString(),
                'is_active' => true,
            ]
        );
        $this->command->info("Coupon created: SAVE5 (5 OMR off, min 30 OMR)");

        Coupon::firstOrCreate(
            ['code' => 'VIP20'],
            [
                'salon_id' => $salon->id,
                'code' => 'VIP20',
                'type' => 'percentage',
                'value' => 20.00,
                'min_order_amount' => 50.00,
                'max_uses' => 20,
                'used_count' => 0,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonths(1)->toDateString(),
                'is_active' => true,
            ]
        );
        $this->command->info("Coupon created: VIP20 (20% off, min 50 OMR)");

        $this->command->info("\n✅ All seeding complete! Default password for all accounts: 12345678");
    }
}
