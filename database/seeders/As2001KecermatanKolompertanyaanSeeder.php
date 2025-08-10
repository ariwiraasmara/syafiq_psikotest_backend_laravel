<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\as2001_kecermatan_kolompertanyaan;
class As2001KecermatanKolompertanyaanSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        as2001_kecermatan_kolompertanyaan::insert([
            [
                'kolom_x' => 'Kolom 1',
                'nilai_A' => 7,
                'nilai_B' => 2,
                'nilai_C' => 5,
                'nilai_D' => 1,
                'nilai_E' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kolom_x' => 'Kolom 2',
                'nilai_A' => 2,
                'nilai_B' => 8,
                'nilai_C' => 6,
                'nilai_D' => 7,
                'nilai_E' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kolom_x' => 'Kolom 3',
                'nilai_A' => 1,
                'nilai_B' => 6,
                'nilai_C' => 8,
                'nilai_D' => 4,
                'nilai_E' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kolom_x' => 'Kolom 4',
                'nilai_A' => 3,
                'nilai_B' => 7,
                'nilai_C' => 9,
                'nilai_D' => 6,
                'nilai_E' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kolom_x' => 'Kolom 5',
                'nilai_A' => 4,
                'nilai_B' => 2,
                'nilai_C' => 7,
                'nilai_D' => 5,
                'nilai_E' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
