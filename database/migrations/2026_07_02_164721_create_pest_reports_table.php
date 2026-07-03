<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pest_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('crop_type');
            $table->string('pest_name');
            $table->enum('severity', ['low', 'medium', 'critical'])->default('low');
            $table->text('description');
            $table->string('status')->default('Under Review');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pest_reports');
    }
};