<?php

namespace Database\Seeders;

use App\Models\System\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Admin()->insert([
            'username' => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('changeme'),
            'token'    => ''
        ]);
    }
}
