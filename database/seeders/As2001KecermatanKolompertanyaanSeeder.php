<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\as2001_kecermatan_kolompertanyaan;

class As2001KecermatanKolompertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        as2001_kecermatan_kolompertanyaan::create(
            [
                'kolom_x' => 'Kolom 1',
                'nilai_1' => 7,
                'nilai_2' => 2,
                'nilai_3' => 5,
                'nilai_4' => 1,
                'nilai_5' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kolom_x' => 'Kolom 2',
                'nilai_1' => 2,
                'nilai_2' => 8,
                'nilai_3' => 6,
                'nilai_4' => 7,
                'nilai_5' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kolom_x' => 'Kolom 3',
                'nilai_1' => 1,
                'nilai_2' => 6,
                'nilai_3' => 8,
                'nilai_4' => 4,
                'nilai_5' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kolom_x' => 'Kolom 4',
                'nilai_1' => 3,
                'nilai_2' => 7,
                'nilai_3' => 9,
                'nilai_4' => 6,
                'nilai_5' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kolom_x' => 'Kolom 5',
                'nilai_1' => 4,
                'nilai_2' => 2,
                'nilai_3' => 7,
                'nilai_4' => 5,
                'nilai_5' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }
}
