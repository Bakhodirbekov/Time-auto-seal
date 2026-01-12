<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['pending', 'in_review', 'resolved', 'rejected'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
