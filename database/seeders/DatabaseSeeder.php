<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'user@global-tickets.com',
        ], [
            'name' => 'Test User',
            'password' => '1234567a',
        ]);
    }
}
