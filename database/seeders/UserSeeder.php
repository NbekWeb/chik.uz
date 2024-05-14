<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name' => 'SuperAdmin',
            'role_id' => 1,
            'cash' => '999000',
            'email' => 'admin@mail.ru',
            'phone' => '+998979260757',
            'password' => Hash::make('password'),
            'email_verified_at' => now()

        ]);
        $freelancer = User::create([
            'name' => 'Freelancer',
            'role_id' => 2,
            'cash' => '1000000',
            'email' => 'freelancer@mail.ru',
            'phone' => '+998979260745',
            'password' => Hash::make('password'),
            'email_verified_at' => now()

        ]);
        $client = User::create([
            'name' => 'Client',
            'role_id' => 3,
            'cash' => '999999',
            'email' => 'client@mail.ru',
            'phone' => '+998979260745',
            'password' => Hash::make('password'),
            'email_verified_at' => now()

        ]);

    }
}
