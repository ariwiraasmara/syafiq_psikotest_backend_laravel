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
        Schema::create('as2001_kecermatan_kolompertanyaan', function (Blueprint $table) {
            $table->id();
            $table->string('kolom_x', 255);
            $table->integer('nilai_A');
            $table->integer('nilai_B');
            $table->integer('nilai_C');
            $table->integer('nilai_D');
            $table->integer('nilai_E');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('as2001_kecermatan_kolompertanyaan');
    }
};
