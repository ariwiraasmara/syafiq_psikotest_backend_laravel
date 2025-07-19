<?php

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
        //
        Schema::create('as5001_blog', function (Blueprint $table) {
            $table->bigInteger('id')->primary()->autoIncrement();
            $table->integer('id_user');
            $table->string('title');
            $table->string('category')->nullable()->default(null);
            $table->longText('content')->nullable()->default(null);
            $table->longText('pictures')->nullable()->default(null);
            $table->enum('status', ['draft', 'public', 'deleted'])->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('as5001_blog');
    }
};
