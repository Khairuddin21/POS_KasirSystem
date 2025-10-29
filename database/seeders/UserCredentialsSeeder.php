<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCredentialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users (optional - comment out if you want to keep existing data)
        User::query()->delete();

        // Create User role
        User::create([
            'name' => 'Hafiz User',
            'email' => 'hafizuser@mail.com',
            'password' => Hash::make('Hafiz123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create Admin role
        User::create([
            'name' => 'Hafiz Admin',
            'email' => 'hafizadmin@mail.com',
            'password' => Hash::make('Hafiz123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Kasir role
        User::create([
            'name' => 'Hafiz Kasir',
            'email' => 'hafizkasir@mail.com',
            'password' => Hash::make('Hafiz123'),
            'role' => 'kasir',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ User credentials created successfully!');
        $this->command->info('📧 User: hafizuser@mail.com | Password: Hafiz123');
        $this->command->info('👨‍💼 Admin: hafizadmin@mail.com | Password: Hafiz123');
        $this->command->info('💰 Kasir: hafizkasir@mail.com | Password: Hafiz123');
    }
}
