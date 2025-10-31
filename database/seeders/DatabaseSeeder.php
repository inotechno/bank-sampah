<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@banksampah.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@banksampah.test'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        $this->call([
            WasteTypeSeeder::class,
        ]);
    }
}
