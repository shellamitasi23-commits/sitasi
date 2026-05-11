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
        User::firstOrCreate(
            ['email' => 'bendahara@tk.com'],
            [
                'name' => 'Bendahara',
                'password' => bcrypt('bendahara123'),
                'role' => 'bendahara',
            ]
        );

        User::firstOrCreate(
            ['email' => 'ketua@tk.com'],
            [
                'name' => 'Ketua',
                'password' => bcrypt('ketua123'),
                'role' => 'ketua',
            ]
        );
    }
}