<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\as2002_kecermatan_soaljawaban;
class As2002KecermatanSoaljawabanSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        as2002_kecermatan_soaljawaban::insert([
            //? Kolom 1, id2001 = 1, id = 1
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 1, 9, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 1, id2001 = 1, id = 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 9, 1, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 1, id2001 = 1, id = 3
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 2, 5, 1]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],
        ]);
    }
}
