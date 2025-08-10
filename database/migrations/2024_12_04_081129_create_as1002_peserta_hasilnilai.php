<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('as1002_peserta_hasilnilai_teskecermatan', function (Blueprint $table) {
            $table->id();
            $table->integer('id1001');
            $table->date('tgl_ujian');
            $table->integer('hasilnilai_kolom_1')->default(null);
            $table->integer('waktupengerjaan_kolom_1')->default(null);
            $table->integer('hasilnilai_kolom_2')->default(null);
            $table->integer('waktupengerjaan_kolom_2')->default(null);
            $table->integer('hasilnilai_kolom_3')->default(null);
            $table->integer('waktupengerjaan_kolom_3')->default(null);
            $table->integer('hasilnilai_kolom_4')->default(null);
            $table->integer('waktupengerjaan_kolom_4')->default(null);
            $table->integer('hasilnilai_kolom_5')->default(null);
            $table->integer('waktupengerjaan_kolom_5')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('as1002_peserta_hasilnilai_teskecermatan');
    }
};
