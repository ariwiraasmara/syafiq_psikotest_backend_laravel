<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace Database\Seeders;

use App\Models\as0001_variabelsetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class As0001VariabelsettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        as0001_variabelsetting::create(
            [
                'variabel'      => 'timer',
                'values'        => '60',
                // 'created_at'    => now(),
                // 'updated_at'    => now(),
            ]
        );
    }
}