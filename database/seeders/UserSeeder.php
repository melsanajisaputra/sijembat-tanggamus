<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;   // ✅ Tambahkan ini
use App\Models\User;                   // ✅ Tambahkan ini

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pupr.go.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'viewer@pupr.go.id'],
            [
                'name' => 'Viewer',
                'password' => Hash::make('viewer123'),
                'role' => 'viewer',
            ]
        );
    }
}
