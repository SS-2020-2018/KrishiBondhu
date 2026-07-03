<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->after('phone');
        });

        DB::table('users')
            ->where('role', '!=', 'farmer')
            ->update(['role' => 'seller']);

        DB::statement("ALTER TABLE users MODIFY role ENUM('farmer', 'seller') NOT NULL DEFAULT 'farmer'");
    }

    public function down(): void
    {
        DB::table('users')
            ->where('role', 'seller')
            ->update(['role' => 'buyer']);

        DB::statement("ALTER TABLE users MODIFY role ENUM('farmer', 'buyer', 'seller', 'admin') NOT NULL DEFAULT 'farmer'");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_image');
        });
    }
};