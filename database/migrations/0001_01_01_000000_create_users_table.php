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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('roles')->nullabble();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0)->nullable();
        });

        Schema::create('users_detail', function (Blueprint $table) {
            $table->id();
            $table->string('no_identitas')->unique()->nullable()->default(null);
            $table->date('tgl_lahir')->nullable()->default(null);
            $table->enum('jk', ['Pria', 'Wanita'])->nullable()->default(null);
            $table->string('alamat')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->string('agama')->nullable()->default(null);
            $table->string('foto')->nullable()->default(null);
        });

        Schema::create('users_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->ipAddress('ip_address')->nullable()->default(null);
            $table->text('path')->nullable()->default(null)->comment('path halaman');
            $table->text('url')->nullable()->default(null)->comment('halaman full url');
            $table->text('page')->nullable()->default(null)->comment('di halaman mana?');
            $table->text('event')->nullable()->default(null)->comment('event adalah jenis method pada halaman (create, read, update, delete)');
            $table->text('deskripsi')->nullable()->default(null)->comment('ngapain? apa yang sedang dilakukan?');
            $table->json('properties')->nullable()->default(null)->comment('properties adalah tangkapan content pada event');
            $table->text('user_agent')->nullable()->default(null);
            $table->timestamp('tanggal')->nullable()->default(date('Y-m-d H:i:s'));
        });

        Schema::create('users_device_history', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->ipAddress('ip_address')->nullable()->default(null);
            $table->text('user_agent')->nullable()->default(null);
            $table->timestamp('last_login', precision: 0)->nullable()->default(null);
            $table->timestamp('last_logout', precision: 0)->nullable()->default(null);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
