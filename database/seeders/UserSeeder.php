<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::insert([
            [
                'name'              => 'Ari Wiraasmara',
                'email'             => 'ariwiraasmara.sc37@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('admin'),
                'remember_token'    => Str::random(50),
                'created_at'        => now(),
            ],
            [
                'name'              => 'Syafiq',
                'email'             => 'syafiq@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('admin'),
                'remember_token'    => Str::random(50),
                'created_at'        => now(),
            ]
        ]);
    }
}
