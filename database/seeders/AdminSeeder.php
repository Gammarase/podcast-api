<?php

namespace Database\Seeders;

use App\Enums\AdminRole;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Main Admin',
            'email' => 'admin@podcast.com',
            'password' => bcrypt('password'),
            'role' => AdminRole::ADMIN,
        ]);
        Admin::factory()->count(5)->create();
    }
}
