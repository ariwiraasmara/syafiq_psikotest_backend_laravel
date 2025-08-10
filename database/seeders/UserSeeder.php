<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserDeviceHistory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::insert([
            [
                'id'                => 1,
                'name'              => 'Superadmin',
                'email'             => 'su@admin.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('5Up3R@D111!n'),
                'remember_token'    => Str::random(100),
                'roles'             => 1,
                'created_at'        => now(),
            ],
            [
                'id'                => 2,
                'name'              => 'Ari Wiraasmara',
                'email'             => 'ariwiraasmara.sc37@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('@12iW'),
                'remember_token'    => Str::random(100),
                'roles'             => 1,
                'created_at'        => now(),
            ],
            [
                'id'                => 3,
                'name'              => 'Syafiq',
                'email'             => 'syafiq@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('@D111!n'),
                'remember_token'    => Str::random(100),
                'roles'             => 1,
                'created_at'        => now(),
            ],
            [
                'id'                => 4,
                'name'              => 'Admin',
                'email'             => 'admin@admin.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('@D111!n'),
                'remember_token'    => Str::random(100),
                'roles'             => 2,
                'created_at'        => now(),
            ]
        ]);

        UserDetail::insert([
            ['id'=>1, 'jk' => 'Pria'],
            ['id'=>2, 'jk' => 'Pria'],
            ['id'=>3, 'jk' => 'Pria'],
            ['id'=>4, 'jk' => 'Pria'],
        ]);

        Storage::makeDirectory(storage_path('logs/user_admin/1.su@admin.com'));
        Storage::makeDirectory(storage_path('logs/user_admin/2.ariwiraasmara.sc37@gmail.com'));
        Storage::makeDirectory(storage_path('logs/user_admin/3.syafiq@gmail.com'));
        Storage::makeDirectory(storage_path('logs/user_admin/4.admin@admin.com'));
    }
}
