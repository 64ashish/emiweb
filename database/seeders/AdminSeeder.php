<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'super admin',
            'email' => 'ashish@kortaben.se',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'is_admin'=> 1,
            'status'=> 1,
        ])->assignRole('super admin');

        User::create([
            'name' => 'emiweb admin',
            'email' => 'emiadmin@kortaben.se',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'is_admin'=> 1,
            'status'=> 1,
        ])->assignRole('emiweb admin');

        User::create([
            'name' => 'emiweb staff',
            'email' => 'emistaff@kortaben.se',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'is_admin'=> 1,
            'status'=> 1,
        ])->assignRole('emiweb staff');

        User::create([
            'name' => 'organization admin',
            'email' => 'orgadmin@kortaben.se',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'is_admin'=> 1,
            'status'=> 1,
        ])->assignRole('organization admin');

        User::create([
            'name' => 'organization staff',
            'email' => 'orgstaff@kortaben.se',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'is_admin'=> 1,
            'status'=> 1,
        ])->assignRole('organization staff');
    }


}
