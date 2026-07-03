<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->enum('role', ['farmer', 'seller'])->default('farmer');
            $table->rememberToken();
            $table->timestamps();
        });

   
        Schema::create('farmer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('profile_image')->nullable(); 
            $table->string('farm_location')->nullable();
            $table->string('crop_type')->nullable();
            $table->decimal('land_size', 8, 2)->nullable();
            $table->text('contact_details')->nullable();
            $table->text('farming_history')->nullable();
            $table->timestamps();
        });

      
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['equipment', 'crop']);
            $table->timestamps();
        });

     
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->enum('listing_type', ['buy', 'sell', 'rent'])->default('sell');
            $table->string('location')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('farmer_profiles');
        Schema::dropIfExists('users');
    }
};