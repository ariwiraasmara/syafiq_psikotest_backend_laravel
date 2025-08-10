<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace Database\Seeders;

use App\Models\PersonalAccessTokens;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Libraries\myfunction;

class PersonalAccessTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        PersonalAccessTokens::insert([
            [
                'id'                => 1,
                'tokenable_type'    => 'App\Models\User',
                'tokenable_id'      => 1, // => id user
                'name'              => 'su@admin.com',
                'token'             => Str::random(64),
                'abilities'         => '["*"]',
                'last_used_at'      => null,
                'expires_at'        => myfunction::daysLater('+30 days'),
                'created_at'        => now()
            ],
            [
                'id'                => 2,
                'tokenable_type'    => 'App\Models\User',
                'tokenable_id'      => 2, // => id user
                'name'              => 'ariwiraasmara.sc37@gmail.com',
                'token'             => Str::random(64),
                'abilities'         => '["*"]',
                'last_used_at'      => null,
                'expires_at'        => myfunction::daysLater('+30 days'),
                'created_at'        => now()
            ],
            [
                'id'                => 3,
                'tokenable_type'    => 'App\Models\User',
                'tokenable_id'      => 3, // => id user
                'name'              => 'syafiq@gmail.com',
                'token'             => Str::random(64),
                'abilities'         => '["*"]',
                'last_used_at'      => null,
                'expires_at'        => myfunction::daysLater('+30 days'),
                'created_at'        => now()
            ],
            [
                'id'                => 4,
                'tokenable_type'    => 'App\Models\User',
                'tokenable_id'      => 4, // => id user
                'name'              => 'admin@admin.com',
                'token'             => Str::random(64),
                'abilities'         => '["admin.peserta" => ["read"],"admin.blog" => "*"]',
                'last_used_at'      => null,
                'expires_at'        => myfunction::daysLater('+30 days'),
                'created_at'        => now()
            ]
        ]);
    }
}
