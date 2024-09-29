<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'type' => 'admin'
        ]);

        $admin_user->createToken($admin_user->name);

        $manager = User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@demo.com',
            'type' => 'admin'
        ]);

        $manager->createToken($manager->name);

        $user = User::factory()->create([
            'name' => 'User1',
            'email' => 'user1@demo.com',
            'type' => 'user'
        ]);

        $user->createToken($user->name);
    }
}
