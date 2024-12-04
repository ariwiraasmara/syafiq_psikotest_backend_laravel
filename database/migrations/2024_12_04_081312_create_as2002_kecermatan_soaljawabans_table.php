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
        Schema::create('as2002_kecermatan_soaljawaban', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id2001');
            $table->string('pertanyaan', 255);
            $table->string('jawaban', 255);
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
