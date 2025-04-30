<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace Database\Seeders;

use App\Models\as1001_peserta_profil;
use App\Models\as1002_peserta_hasilnilai_teskecermatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Libraries\myfunction as fun;
class As1001PesertaProfilSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        as1001_peserta_profil::insert([
            [
                'nama'          => 'Syahri Ramadhan Wiraasmara',
                'no_identitas'  => '3604020302950075',
                'email'         => 'ariwiraasmara.sc37@gmail.com',
                'tgl_lahir'     => '1995-02-03',
                'usia'          => 29,
                'asal'          => 'Cipocok Jaya, Serang, Banten',
            ],
            [
                'nama'          => 'Sofia Coquille',
                'no_identitas'  => '3604020711950003',
                'email'         => 'sofia.sc37@gmail.com',
                'tgl_lahir'     => '1995-11-07',
                'usia'          => 29,
                'asal'          => 'Cipocok Jaya, Serang, Banten',
            ],
        ]);

        as1002_peserta_hasilnilai_teskecermatan::insert([
            [
                'id1001'                 => 1,
                'tgl_ujian'              => date('2024-01-01 H:i:s'),
                'hasilnilai_kolom_1'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_1' => rand(0,60),
                'hasilnilai_kolom_2'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_2' => rand(0,60),
                'hasilnilai_kolom_3'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_3' => rand(0,60),
                'hasilnilai_kolom_4'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_4' => rand(0,60),
                'hasilnilai_kolom_5'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_5' => rand(0,60),
            ],
            [
                'id1001'                => 1,
                'tgl_ujian'             => date('2024-02-02 H:i:s'),
                'hasilnilai_kolom_1'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_1' => rand(0,60),
                'hasilnilai_kolom_2'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_2' => rand(0,60),
                'hasilnilai_kolom_3'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_3' => rand(0,60),
                'hasilnilai_kolom_4'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_4' => rand(0,60),
                'hasilnilai_kolom_5'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_5' => rand(0,60),
            ],
            [
                'id1001'                 => 1,
                'tgl_ujian'              => date('2024-03-03 H:i:s'),
                'hasilnilai_kolom_1'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_1' => rand(0,60),
                'hasilnilai_kolom_2'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_2' => rand(0,60),
                'hasilnilai_kolom_3'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_3' => rand(0,60),
                'hasilnilai_kolom_4'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_4' => rand(0,60),
                'hasilnilai_kolom_5'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_5' => rand(0,60),
            ],
            [
                'id1001'                 => 2,
                'tgl_ujian'              => date('2024-01-01 H:i:s'),
                'hasilnilai_kolom_1'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_1' => rand(0,60),
                'hasilnilai_kolom_2'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_2' => rand(0,60),
                'hasilnilai_kolom_3'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_3' => rand(0,60),
                'hasilnilai_kolom_4'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_4' => rand(0,60),
                'hasilnilai_kolom_5'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_5' => rand(0,60),
            ],
            [
                'id1001'                 => 2,
                'tgl_ujian'              => date('2024-02-02 H:i:s'),
                'hasilnilai_kolom_1'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_1' => rand(0,60),
                'hasilnilai_kolom_2'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_2' => rand(0,60),
                'hasilnilai_kolom_3'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_3' => rand(0,60),
                'hasilnilai_kolom_4'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_4' => rand(0,60),
                'hasilnilai_kolom_5'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_5' => rand(0,60),
            ],
            [
                'id1001'                 => 2,
                'tgl_ujian'              => date('2024-03-03 H:i:s'),
                'hasilnilai_kolom_1'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_1' => rand(0,60),
                'hasilnilai_kolom_2'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_2' => rand(0,60),
                'hasilnilai_kolom_3'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_3' => rand(0,60),
                'hasilnilai_kolom_4'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_4' => rand(0,60),
                'hasilnilai_kolom_5'     => fun::random('numb', 2),
                'waktupengerjaan_kolom_5' => rand(0,60),
            ],
        ]);
        
        for($x = 3; $x < 103; $x++) {
            as1001_peserta_profil::insert([
                [
                    'nama'          => 'Peserta User '.$x,
                    'no_identitas'  => fun::random('numb', 10),
                    'email'         => 'peserta'.$x.'@gmail.com',
                    'tgl_lahir'     => '1995-01-01',
                    'usia'          => 25,
                    'asal'          => 'Negeri X-'.$x,
                ]
            ]);
            
            as1002_peserta_hasilnilai_teskecermatan::insert([
                [
                    'id1001'                => $x,
                    'tgl_ujian'             => date('2024-01-01 H:i:s'),
                    'hasilnilai_kolom_1'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_1' => rand(0,60),
                    'hasilnilai_kolom_2'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_2' => rand(0,60),
                    'hasilnilai_kolom_3'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_3' => rand(0,60),
                    'hasilnilai_kolom_4'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_4' => rand(0,60),
                    'hasilnilai_kolom_5'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_5' => rand(0,60),
                ],
                [
                    'id1001'                => $x,
                    'tgl_ujian'             => date('2024-02-02 H:i:s'),
                    'hasilnilai_kolom_1'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_1' => rand(0,60),
                    'hasilnilai_kolom_2'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_2' => rand(0,60),
                    'hasilnilai_kolom_3'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_3' => rand(0,60),
                    'hasilnilai_kolom_4'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_4' => rand(0,60),
                    'hasilnilai_kolom_5'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_5' => rand(0,60),
                ],
                [
                    'id1001'                => $x,
                    'tgl_ujian'             => date('2024-03-03 H:i:s'),
                    'hasilnilai_kolom_1'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_1' => rand(0,60),
                    'hasilnilai_kolom_2'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_2' => rand(0,60),
                    'hasilnilai_kolom_3'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_3' => rand(0,60),
                    'hasilnilai_kolom_4'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_4' => rand(0,60),
                    'hasilnilai_kolom_5'     => fun::random('numb', 2),
                    'waktupengerjaan_kolom_5' => rand(0,60),
                ],
            ]);
        }
    }
}
