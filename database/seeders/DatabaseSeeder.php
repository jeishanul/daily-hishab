<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Jeishanul Haque Shishir',
            'email' => 'shishirjeishanul@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('@haque511.com'),
            'remember_token' => Str::random(10),
        ]);

        $user->wallet()->create([
            'balance' => 55571 - 30000,
        ]);
    }
}
