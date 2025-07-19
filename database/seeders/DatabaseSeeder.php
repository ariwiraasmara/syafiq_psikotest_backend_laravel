<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Sanctum\PersonalAccessToken;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
        $this->call(PersonalAccessTokenSeeder::class);
        $this->call(As0001VariabelsettingSeeder::class);
        $this->call(As1001PesertaProfilSeeder::class);
        $this->call(As1002PesertaHasilnilaiTesKecermatanSeeder::class);
        $this->call(As2001KecermatanKolompertanyaanSeeder::class);
        $this->call(As2002KecermatanSoaljawabanSeeder::class);
    }
}
