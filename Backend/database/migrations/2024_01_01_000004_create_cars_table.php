<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->boolean('price_visible')->default(false);
            
            // Car Details
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('color')->nullable();
            $table->integer('mileage')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('transmission')->nullable();
            $table->string('condition')->nullable();
            $table->string('location')->nullable();
            
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'sold'])->default('pending');
            $table->boolean('is_hot_deal')->default(false);
            $table->boolean('is_featured')->default(false);
            
            // Timer
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('timer_end_at')->nullable();
            $table->boolean('timer_expired')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'is_hot_deal', 'is_featured']);
            $table->index(['timer_end_at', 'timer_expired']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
