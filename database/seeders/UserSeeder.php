<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
            'email' => 'admin@mail.ru',
            // 'phone' => '+998979260757',
            'password' => Hash::make('password'),
        ]);
        $freelancer = User::create([
            'name' => 'Freelancer',
            'role_id' => 2,
            'email' => 'freelancer@mail.ru',
            // 'phone' => '+998979260745',
            'password' => Hash::make('password'),
        ]);


        $client = User::create([
            'name' => 'Client',
            'role_id' => 3,
            'email' => 'client@mail.ru',
            'cash' => '999999',
            'password' => Hash::make('password'),
        ]);

    }
}
