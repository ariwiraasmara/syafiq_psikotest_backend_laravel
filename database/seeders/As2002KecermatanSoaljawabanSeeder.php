<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
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
        //? Kolom 1
        as2002_kecermatan_soaljawaban::insert([
            //? Kolom 1, id2001 = 1, id = 1
            //? 2, 1, 9, 5, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 1, 9, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 2
            //? 2, 9, 1, 7, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 9, 1, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 3
            //? 7, 2, 5, 1, 9
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 2, 5, 1]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 4
            //? 1, 9, 2, 7, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 9, 2, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 5
            //? 5, 2, 9, 1, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[5, 2, 9, 1]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 6
            //? 9, 5, 7, 2, 1
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[9, 5, 7, 2]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 7
            //? 5, 1, 7, 9, 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[5, 1, 7, 9]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 8
            //? 1, 7, 2, 5, 9
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 7, 2, 5]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 9
            //? 2, 1, 9, 7, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 1, 9, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 10
            //? 5, 9, 7, 1, 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[5, 9, 7, 1]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 11
            // 1, 7, 9, 2, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 7, 9, 2]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 12
            // 9, 2, 5, 7, 1
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[9, 2, 5, 7]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 13
            // 1, 7, 2, 9, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 7, 2, 9]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 14
            // 2, 9, 5, 1, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 9, 5, 1]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 15
            // 5, 7, 9, 1, 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 9, 1]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 16
            // 2, 1, 7, 5, 9
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 1, 7, 5]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 17
            // 2, 9, 1, 7, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 9, 1, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 18
            // 7, 1, 2, 9, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 1, 2, 9]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 19
            // 9, 5, 7, 2, 1
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[9, 5, 7, 2]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 20
            // 2, 9, 1, 5, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 9, 1, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 21
            // 9, 1, 7, 2, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[9, 1, 7, 2]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 22
            // 7, 5, 9, 1, 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 5, 9, 1]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 23
            // 1, 7, 5, 2, 9
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 7, 5, 2]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 24
            // 7, 5, 9, 2, 1
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 5, 9, 2]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 25
            // 5, 9, 1, 7, 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[5, 9, 1, 7]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 26
            // 9, 7, 1, 5, 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[9, 7, 1, 5]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 27
            // 9, 5, 7, 2, 1
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[9, 5, 7, 2]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 28
            // 1, 9, 2, 7, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 9, 2, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 29
            // 7, 1, 9, 2, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 1, 9, 2]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 30
            // 1, 5, 2, 9, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 5, 2, 9]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 31
            // 1, 7, 2, 5, 9
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 7, 2, 5]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 32
            // 2, 1, 9, 7, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 1, 9, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 33
            // 7, 9, 5, 1, 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 9, 5, 1]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 34
            // 9, 1, 2, 5, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[9, 1, 2, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 35
            // 2, 7, 1, 9, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 7, 1, 9]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 36
            // 2, 5, 7, 9, 1
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 5, 7, 9]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 37
            // 7, 1, 5, 2, 9
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 1, 5, 2]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 38
            // 7, 5, 2, 9, 1
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 5, 2, 9]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 39
            // 1, 2, 9, 5, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 2, 9, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 40
            // 7, 9, 1, 2, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 9, 1, 2]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 41
            // 2, 1, 7, 5, 9
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 1, 7, 5]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 42
            // 1, 2, 5, 9, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 2, 5, 9]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 43
            // 5, 7, 9, 1, 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 9, 1]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 44
            // 1, 9, 5, 2, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 9, 5, 2]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 45
            // 9, 1, 7, 5, 2
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[9, 1, 7, 5]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 46
            // 2, 7, 1, 9, 5
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 7, 1, 9]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 47
            // 7, 2, 9, 5, 1
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[7, 2, 9, 5]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 48
            // 2, 1, 5, 7, 9
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 1, 5, 7]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 49
            // 1, 5, 2, 9, 7
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[1, 5, 2, 9]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 1, id2001 = 1, id = 50
            // 2, 1, 5, 7, 9
            ['id2001' => 1, 'soal_jawaban' => json_encode(['soal' => [[2, 1, 5, 7]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],
        ]);


        //? Kolom 2
        as2002_kecermatan_soaljawaban::insert([

            //? Kolom 2, id2001 = 2, id = 1
            //? 6, 7, 5, 2, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 7, 5, 2]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 2
            //? 7, 5, 2, 6, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[7, 5, 2, 6]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 3
            //? 5, 7, 6, 8, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 6, 8]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 4
            //? 5, 6, 8, 2, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 6, 8, 2]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 5
            //? 2, 8, 6, 7, 5
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 8, 6, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 6
            //? 6, 5, 7, 8, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 5, 7, 8]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 7
            //? 2, 7, 8, 5, 6
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 7, 8, 5]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 8
            //? 8, 7, 2, 6, 5
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[8, 7, 2, 6]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 9
            //? 5, 8, 6, 2, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 8, 6, 2]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 10
            //? 6, 2, 8, 5, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 2, 8, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 11
            //? 8, 6, 2, 7, 5
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[8, 6, 2, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 12
            //? 6, 8, 7, 2, 5
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 8, 7, 2]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 12
            //? 7, 6, 8, 5, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[7, 6, 8, 5]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 13
            //? 8, 7, 5, 2, 6
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[8, 7, 5, 2]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 14
            //? 5, 6, 2, 8, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 6, 2, 8]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 15
            //? 2, 7, 5, 6, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 7, 5, 6]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 16
            //? 7, 2, 8, 5, 6
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[7, 2, 8, 5]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 17
            //? 6, 8, 7, 2, 5
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 8, 7, 2]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 19
            //? 8, 2, 5, 6, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[8, 2, 5, 6]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 20
            //? 5, 2, 7, 8, 6
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 2, 7, 8]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 21
            //? 5, 7, 6, 2, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 6, 2]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 22
            //? 6, 5, 8, 7, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 5, 8, 7]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 23
            //? 6, 8, 5, 2, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 8, 5, 2]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 24
            //? 5, 7, 8, 6, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 8, 6]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 25
            //? 7, 6, 5, 2, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[7, 6, 5, 2]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 26
            //? 6, 8, 2, 7, 5
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 8, 2, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 27
            //? 8, 2, 5, 6, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[8, 2, 5, 6]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 28
            //? 2, 8, 7, 5, 6
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 8, 7, 5]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 29
            //? 8, 2, 6, 7, 5
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[8, 2, 6, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 30
            //? 5, 7, 8, 6, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 8, 6]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 31
            //? 5, 6, 7, 2, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 6, 7, 2]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 32
            //? 6, 2, 8, 5, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 2, 8, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 33
            //? 2, 8, 5, 6, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 8, 5, 6]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 34
            //? 6, 2, 7, 8, 5
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 2, 7, 8]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 35
            //? 8, 7, 5, 6, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[8, 7, 5, 6]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 36
            //? 2, 5, 7, 8, 6
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 5, 7, 8]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 37
            //? 7, 2, 5, 6, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[7, 2, 5, 6]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 38
            //? 2, 7, 5, 8, 6
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 7, 5, 8]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 39
            //? 5, 8, 6, 2, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 8, 6, 2]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 40
            //? 8, 5, 7, 6, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[8, 5, 7, 6]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 41
            //? 5, 7, 2, 8, 6
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 2, 8]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 42
            //? 2, 5, 7, 6, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 5, 7, 6]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 43
            //? 6, 2, 5, 8, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 2, 5, 8]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 44
            //? 2, 8, 6, 7, 5
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 8, 6, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 45
            //? 2, 6, 8, 5, 7
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[2, 6, 8, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 46
            //? 6, 7, 5, 8, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 7, 5, 8]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 47
            //? 5, 7, 2, 6, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 2, 6]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 48
            //? 6, 2, 7, 5, 8
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[6, 2, 7, 5]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 49
            //? 7, 6, 5, 8, 2
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[7, 6, 5, 8]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 2, id2001 = 2, id = 50
            //? 5, 7, 8, 2, 6
            ['id2001' => 2, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 8, 2]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],
        ]);

        //? Kolom 3
        as2002_kecermatan_soaljawaban::insert([
            //? Kolom 3, id2001 = 3, id = 1
            //? 4, 9, 6, 1, 8
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 9, 6, 1]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 2
            //? 1, 6, 8, 4, 9
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 6, 8, 4]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 3
            //? 1, 8, 9, 6, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 8, 9, 6]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 4
            //? 1, 9, 4, 8, 6
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 9, 4, 8]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 5
            //? 1, 4, 8, 9, 6
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 4, 8, 9]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 6
            //? 9, 8, 6, 1, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[9, 8, 6, 1]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 7
            //? 4, 9, 6, 1, 8
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 9, 6, 1]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 8
            //? 1, 6, 4, 8, 9
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 6, 4, 8]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 9
            //? 6, 8, 9, 4, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[6, 8, 9, 4]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 10
            //? 8, 6, 1, 9, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[8, 6, 1, 9]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 11
            //? 1, 4, 6, 8, 9
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 4, 6, 8]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 12
            //? 4, 9, 8, 1, 6
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 9, 8, 1]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 13
            //? 4, 9, 1, 6, 8
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 9, 1, 6]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 14
            //? 8, 6, 9, 4, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[8, 6, 9, 4]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 15
            //? 1, 8, 4, 9, 6
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 8, 4, 9]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 16
            //? 6, 4, 8, 1, 9
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[6, 4, 8, 1]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 17
            //? 8, 4, 9, 6, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[8, 4, 9, 6]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 18
            //? 4, 9, 6, 1, 8
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 9, 6, 1]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 19
            //? 1, 6, 4, 8, 9
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 6, 4, 8]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 20
            //? 1, 8, 6, 9, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 8, 6, 9]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 21
            //? 4, 1, 9, 8, 6
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 1, 9, 8]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 22
            //? 1, 8, 6, 4, 9
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 8, 6, 4]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 23
            //? 4, 9, 8, 6, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 9, 8, 6]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 24
            //? 9, 6, 1, 4, 8
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[9, 6, 1, 4]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 25
            //? 1, 9, 6, 8, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 9, 6, 8]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 26
            //? 6, 8, 9, 4, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[6, 8, 9, 4]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 27
            //? 1, 9, 4, 8, 6
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 9, 4, 8]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 28
            //? 6, 1, 8, 9, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[6, 1, 8, 9]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 29
            //? 4, 6, 1, 8, 9
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 6, 1, 8]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 30
            //? 8, 4, 6, 9, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[8, 4, 6, 9]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 31
            //? 1, 6, 9, 4, 8
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 6, 9, 4]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 32
            //? 6, 4, 8, 9, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[6, 4, 8, 9]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 33
            //? 1, 8, 6, 4, 9
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 8, 6, 4]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 34
            //? 8, 6, 9, 1, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[8, 6, 9, 1]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 35
            //? 9, 1, 4, 8, 6
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[9, 1, 4, 8]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 36
            //? 4, 9, 8, 6, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 9, 8, 6]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 37
            //? 1, 4, 6, 9, 8
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 4, 6, 9]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 38
            //? 6, 8, 9, 1, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[6, 8, 9, 1]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 39
            //? 9, 6, 4, 8, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[9, 6, 4, 8]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],
            
            //? Kolom 3, id2001 = 3, id = 40
            //? 9, 8, 6, 1, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[9, 8, 6, 1]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 41
            //? 4, 8, 9, 6, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 8, 9, 6]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 42
            //? 1, 9, 8, 4, 6
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 9, 8, 4]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 43
            //? 1, 8, 6, 4, 9
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[1, 8, 6, 4]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 44
            //? 4, 6, 1, 9, 8
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 6, 1, 9]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 45
            //? 9, 1, 8, 6, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[9, 1, 8, 6]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 46
            //? 8, 9, 6, 4, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[8, 9, 6, 4]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 47
            //? 6, 4, 8, 9, 1
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[6, 4, 8, 9]], 'jawaban' => 1]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 48
            //? 4, 1, 9, 8, 6
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[4, 1, 9, 8]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 49
            //? 6, 9, 8, 1, 4
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[6, 9, 8, 1]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 3, id2001 = 3, id = 50
            //? 9, 1, 4, 6, 8
            ['id2001' => 3, 'soal_jawaban' => json_encode(['soal' => [[9, 1, 4, 6]], 'jawaban' => 8]), 'created_at' => date('Y-m-d H:i:s')],
        ]);

        //? Kolom 4
        as2002_kecermatan_soaljawaban::insert([
            //? Kolom 4, id2001 = 4, id = 1
            //? 7, 3, 9, 4, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 3, 9, 4]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 2
            //? 6, 7, 3, 9, 4
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 7, 3, 9]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 3
            //? 3, 7, 6, 4, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 7, 6, 4]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 4
            //? 3, 7, 9, 6, 4
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 7, 9, 6]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 5
            //? 9, 4, 3, 7, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[9, 4, 3, 7]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 6
            //? 9, 6, 4, 7, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[9, 6, 4, 7]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 7
            //? 4, 9, 6, 3, 7
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[4, 9, 6, 3]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 8
            //? 7, 6, 4, 9, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 6, 4, 9]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 9
            //? 6, 7, 3, 4, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 7, 3, 4]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 10
            //? 9, 3, 4, 7, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[9, 3, 4, 7]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],
            //? Kolom 4, id2001 = 4, id = 11
            //? 7, 4, 9, 3, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 4, 9, 3]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 12
            //? 3, 6, 7, 9, 4
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 6, 7, 9]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 13
            //? 7, 9, 6, 4, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 9, 6, 4]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 14
            //? 6, 3, 4, 7, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 3, 4, 7]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 15
            //? 7, 4, 3, 9, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 4, 3, 9]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 16
            //? 3, 9, 6, 4, 7
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 9, 6, 4]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 17
            //? 4, 3, 9, 7, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[4, 3, 9, 7]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 18
            //? 6, 4, 3, 9, 7
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 4, 3, 9]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 19
            //? 7, 6, 4, 3, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 6, 4, 3]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 20
            //? 9, 3, 7, 4, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[9, 3, 7, 4]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 21
            //? 7, 9, 3, 6, 4
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 9, 3, 6]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 22
            //? 3, 4, 6, 7, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 4, 6, 7]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 23
            //? 7, 6, 9, 4, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 6, 9, 4]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 24
            //? 3, 9, 4, 7, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 9, 4, 7]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 25
            //? 4, 3, 6, 7, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[4, 3, 6, 7]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 26
            //? 4, 6, 9, 3, 7
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[4, 6, 9, 3]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 27
            //? 3, 4, 9, 7, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 4, 9, 7]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 28
            //? 7, 3, 4, 9, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 3, 4, 9]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 29
            //? 7, 6, 3, 4, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 6, 3, 4]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 30
            //? 6, 9, 7, 4, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 9, 7, 4]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 31
            //? 9, 6, 7, 3, 4
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[9, 6, 7, 3]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 32
            //? 3, 7, 9, 4, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 7, 9, 4]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 33
            //? 7, 3, 6, 9, 4
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 3, 6, 9]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 34
            //? 6, 3, 9, 4, 7
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 3, 9, 4]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 35
            //? 9, 4, 3, 7, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[9, 4, 3, 7]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 36
            //? 7, 9, 4, 6, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 9, 4, 6]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 37
            //? 7, 4, 6, 3, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 4, 6, 3]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 38
            //? 7, 9, 4, 6, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 9, 4, 6]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 39
            //? 3, 7, 9, 6, 4
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 7, 9, 6]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 40
            //? 6, 3, 7, 4, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 3, 7, 4]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 41
            //? 4, 6, 3, 9, 7
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[4, 6, 3, 9]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 42
            //? 9, 4, 7, 6, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[9, 4, 7, 6]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 43
            //? 9, 7, 4, 3, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[9, 7, 4, 3]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 44
            //? 6, 9, 3, 7, 4
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 9, 3, 7]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 45
            //? 4, 3, 9, 6, 7
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[4, 3, 9, 6]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 46
            //? 7, 4, 3, 9, 6
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 4, 3, 9]], 'jawaban' => 6]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 47
            //? 7, 9, 4, 6, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[7, 9, 4, 6]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 48
            //? 6, 7, 9, 3, 7
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 7, 9, 3]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 49
            //? 3, 6, 7, 4, 9
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[3, 6, 7, 4]], 'jawaban' => 9]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 4, id2001 = 4, id = 50
            //? 6, 9, 4, 7, 3
            ['id2001' => 4, 'soal_jawaban' => json_encode(['soal' => [[6, 9, 4, 7]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],
        ]);

        //? Kolom 5
        as2002_kecermatan_soaljawaban::insert([
            //? Kolom 5, id2001 = 5, id = 1
            //? 4, 2, 7, 5, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 2, 7, 5]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 2
            //? 7, 3, 4, 5, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 3, 4, 5]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 3
            //? 2, 7, 3, 4, 5
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[2, 7, 3, 4]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 4
            //? 4, 5, 7, 2, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 5, 7, 2]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 5
            //? 2, 3, 5, 7, 4
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[2, 3, 5, 7]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 6
            //? 5, 4, 7, 3, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[5, 4, 7, 3]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 7
            //? 7, 2, 4, 5, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 2, 4, 5]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 8
            //? 3, 7, 2, 4, 5
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 7, 2, 4]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 9
            //? 7, 5, 3, 2, 4
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 5, 3, 2]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 10
            //? 4, 3, 7, 5, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 3, 7, 5]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 11
            //? 5, 2, 4, 7, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[5, 2, 4, 7]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 12
            //? 2, 3, 5, 4, 7
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[2, 3, 5, 4]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 13
            //? 7, 4, 3, 2, 5
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 4, 3, 2]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 14
            //? 3, 5, 7, 4, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 5, 7, 4]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 15
            //? 2, 4, 5, 3, 7
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[2, 4, 5, 3]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 16
            //? 2, 7, 4, 5, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[2, 7, 4, 5]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 17
            //? 5, 2, 3, 7, 4
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[5, 2, 3, 7]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 18
            //? 3, 4, 5, 7, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 4, 5, 7]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 19
            //? 7, 2, 3, 4, 5
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 2, 3, 4]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 20
            //? 7, 4, 5, 2, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 4, 5, 2]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 21
            //? 4, 3, 5, 2, 7
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 3, 5, 2]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 22
            //? 7, 4, 3, 5, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 4, 3, 5]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 23
            //? 5, 7, 2, 4, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 2, 4]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 24
            //? 7, 5, 3, 2, 4
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 5, 3, 2]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 25
            //? 2, 7, 5, 4, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[2, 7, 5, 4]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 26
            //? 3, 2, 4, 7, 5
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 2, 4, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 27
            //? 7, 4, 5, 3, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 4, 5, 3]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 28
            //? 7, 2, 4, 5, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 2, 4, 5]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 29
            //? 3, 5, 2, 4, 7
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 5, 2, 4]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 30
            //? 4, 3, 7, 2, 5
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 3, 7, 2]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 31
            //? 5, 7, 2, 4, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[5, 7, 2, 4]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 32
            //? 3, 5, 7, 2, 4
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 5, 7, 2]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 33
            //? 5, 4, 7, 3, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[5, 4, 7, 3]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 34
            //? 2, 7, 5, 4, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[2, 7, 5, 4]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 35
            //? 3, 2, 7, 4, 5
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 2, 7, 4]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 36
            //? 7, 5, 2, 3, 4
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 5, 2, 3]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 37
            //? 4, 7, 5, 2, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 7, 5, 2]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 38
            //? 3, 5, 4, 2, 7
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 5, 4, 2]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 39
            //? 4, 2, 3, 7, 5
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 2, 3, 7]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 40
            //? 7, 5, 4, 3, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 5, 4, 3]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 41
            //? 7, 2, 5, 3, 4
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 2, 5, 3]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 42
            //? 5, 2, 3, 4, 7
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[5, 2, 3, 4]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 43
            //? 4, 5, 2, 7, 3
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 5, 2, 7]], 'jawaban' => 3]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 44
            //? 2, 3, 4, 5, 7
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[2, 3, 4, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 45
            //? 7, 4, 3, 5, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 4, 3, 5]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 46
            //? 4, 2, 7, 3, 5
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 2, 7, 3]], 'jawaban' => 5]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 47
            //? 3, 4, 5, 2, 7
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 4, 5, 2]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 48
            //? 7, 5, 2, 3, 4
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[7, 5, 2, 3]], 'jawaban' => 4]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 49
            //? 3, 2, 4, 5, 7
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[3, 2, 4, 5]], 'jawaban' => 7]), 'created_at' => date('Y-m-d H:i:s')],

            //? Kolom 5, id2001 = 5, id = 50
            //? 4, 3, 5, 7, 2
            ['id2001' => 5, 'soal_jawaban' => json_encode(['soal' => [[4, 3, 5, 7]], 'jawaban' => 2]), 'created_at' => date('Y-m-d H:i:s')],
        ]);
    }
}