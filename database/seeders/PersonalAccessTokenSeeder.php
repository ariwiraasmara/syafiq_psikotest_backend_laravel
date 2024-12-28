<?php

namespace Database\Seeders;

use App\Models\PersonalAccessTokens;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Libraries\myfunction as fun;

class PersonalAccessTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        PersonalAccessTokens::insert([
            [
                'tokenable_type' => 'App\Models\User',
                'tokenable_id' => 1, // => id user
                'name' => 'ariwiraasmara.sc37@gmail.com',
                'token' => fun::random('combwisp', 64),
                'abilities' => '["*"]',
                'last_used_at' => null,
                'expires_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tokenable_type' => 'App\Models\User',
                'tokenable_id' => 2, // => id user
                'name' => 'syafiq@gmail.com',
                'token' => fun::random('combwisp', 64),
                'abilities' => '["*"]',
                'last_used_at' => null,
                'expires_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
