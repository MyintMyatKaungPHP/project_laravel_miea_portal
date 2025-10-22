<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles နဲ့ Permissions တွေ ဦးစွာဖန်တီးခြင်း
        $this->call(RoleAndPermissionSeeder::class);

        // Super Admin User ဖန်တီးခြင်း
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@email.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole('super_admin');

        // Admin User ဖန်တီးခြင်း
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // User ဖန်တီးခြင်း
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');

        // Blog Categories နဲ့ Posts ဖန်တီးခြင်း
        $this->call([
            CategorySeeder::class,
            PostSeeder::class,
            // ApiDocsSeeder::class, // Disabled - using markdown documentation instead
        ]);

        // $this->call(SiteSettingSeeder::class);
    }
}
