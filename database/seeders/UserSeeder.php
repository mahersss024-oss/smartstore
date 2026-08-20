<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::query()->updateOrCreate([
            'email' => 'super@shelfcurator.com',
        ], [
            'name' => 'Super',
            'password' => Hash::make('Super@shelfcurator#1'),
            'email_verified_at' => now(),
        ]);

        $superAdmin->assignRole('super-admin');
    }
}
