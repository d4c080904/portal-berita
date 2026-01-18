<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Jalankan seeder kategori
        $this->call([
            CategorySeeder::class,
        ]);

        // 2. (opsional) user biasa contoh
        // User::factory(10)->create();

        // 3. Buat user admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password-ku-aman'),
                'is_admin' => 1,
            ]
        );
    }
}
