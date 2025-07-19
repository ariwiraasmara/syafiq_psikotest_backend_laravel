<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('as1001_peserta_profil', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('no_identitas', 255)->unique();
            $table->string('email', 255)->nullable()->default(null);
            $table->date('tgl_lahir');
            $table->integer('usia')->nullable()->default(null);
            $table->string('asal', 255)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('as1001_peserta_profil');
    }
};
