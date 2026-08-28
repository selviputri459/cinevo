<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'profile_photo' => null,
        ]);

        Admin::create([
            'name' => 'Kasir',
            'email' => 'Kasir@gmail.com',
            'password' => Hash::make('password'),
            'profile_photo' => null,
        ]);
    }
}
