<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        if (!Schema::connection($connection)->hasTable('admin_login_logs')) {
            Schema::connection($connection)->create('admin_login_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('username', 120)->nullable()->index();
                $table->string('ip', 45)->nullable()->index();
                $table->text('user_agent')->nullable();
                $table->string('event', 30)->index(); // login, failed, logout
                $table->timestamps();
                $table->index('created_at');
            });
        }
    }

    public function down(): void
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        Schema::connection($connection)->dropIfExists('admin_login_logs');
    }
};
