<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::query()->updateOrCreate(['name' => 'super-admin']);
        Role::query()->updateOrCreate(['name' => 'creator']);
    }
}
