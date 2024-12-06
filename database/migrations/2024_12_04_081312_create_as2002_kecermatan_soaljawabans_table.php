<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('as2002_kecermatan_soaljawaban', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id2001');
            // $table->integer('soal_sub1');
            // $table->integer('soal_sub2');
            // $table->integer('soal_sub3');
            // $table->integer('soal_sub4');
            // $table->integer('jawaban');
            $table->json('soal_jawaban')->comment('soal dan jawaban menggunakan tipe data json. untuk jawaban ada di key kolom ke-5 (urutan key kolom dimulai dari angka 1 dalam bahasa manusia)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('as2002_kecermatan_soaljawaban');
    }
};
