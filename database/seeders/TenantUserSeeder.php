<?php

namespace Database\Seeders;

use App\Models\Central\User;
use Illuminate\Database\Seeder;

class TenantUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Tenant Admin',
            'email' => 'admin@tenant.test',
            'password' => bcrypt('password'), // Change this or make it configurable
        ]);
    }
}
