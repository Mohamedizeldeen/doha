<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'eng.mohamed.izeldeen@gmail.com'],
            [
                'name' => 'Super Admin',
                'email' => 'eng.mohamed.izeldeen@gmail.com',
                'password' => Hash::make('Mohamed1993816$'),
                'role' => 'super_admin',
            ]
        );
        User::firstOrCreate(
            ['email'=> 'doha@email.com'],
            [
                'name' => 'Doha Admin',
                'email' => 'doha@email.com',
                'password' => Hash::make('Doha1996$'),
                'role' => 'super_admin',
            ]
        );
    }
}
