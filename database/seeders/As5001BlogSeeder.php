<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\as5001_blog;

class As5001BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        $status = ['draft', 'public'];
        $category = ['Acara', 'Artikel', 'Informasi', 'Kegiatan'];
        $c = 0;
        $s = 0;
        $y = 1;
        for ($x = 1; $x < 41; $x++) {
            $id_user = ceil($x / 10);
            as5001_blog::create([
                'id'         => $x,
                'id_user'    => $id_user,
                'title'      => 'Title '.$id_user.'.'.$y,
                'category'   => $category[$c],
                'content'    => 'User '.$id_user.', Content ' . $y,
                'created_at' => now(),
                'status'     => $status[$s]
            ]);
            $c++;
            $s++;
            $y++;
            if($c == 4) $c = 0;
            if($s == 2) $s = 0;
            if($y == 11) $y = 1;
        }
    }
}
