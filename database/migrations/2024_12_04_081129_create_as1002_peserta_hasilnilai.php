<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('as1002_peserta_hasilnilai', function (Blueprint $table) {
            $table->I;
            $table->integer('id1001');
            $table->integer('hasilnilai_kolom_1')->default(null);
            $table->integer('hasilnilai_kolom_2')->default(null);
            $table->integer('hasilnilai_kolom_3')->default(null);
            $table->integer('hasilnilai_kolom_4')->default(null);
            $table->integer('hasilnilai_kolom_5')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('as1002_peserta_hasilnilai');
    }
};