<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};